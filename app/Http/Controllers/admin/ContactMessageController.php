<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $messages = ContactMessage::orderBy('created_at', 'desc');

            return DataTables::of($messages)
                ->addIndexColumn()
                ->addColumn('sender_details', function ($row) {
                    $readStatus = is_null($row->read_at)
                        ? '<span class="badge badge-primary">New</span>'
                        : '';

                    $name = '<strong>' . e($row->name) . '</strong> ' . $readStatus;
                    $email = '<br><small class="text-muted">' . e($row->email) . '</small>';

                    return $name . $email;
                })
                ->addColumn('subject_preview', function ($row) {
                    $subject = e($row->subject);

                    // aman: potong string lalu escape
                    $msg = (string) $row->message;
                    $previewText = mb_substr($msg, 0, 100);
                    $preview = '<br><small class="text-muted">' . e($previewText) . '...</small>';

                    return $subject . $preview;
                })
                ->addColumn('received_at', function ($row) {
                    return e($row->created_at->format('d M Y, H:i'));
                })
                ->addColumn('action', function ($row) {
                    $showUrl = route('admin.contact-messages.show', $row->id);
                    $deleteUrl = route('admin.contact-messages.destroy', $row->id);

                    return '
                        <div class="btn-group" role="group">
                            <a href="' . e($showUrl) . '" class="btn btn-sm btn-info" title="View Message">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn" data-url="' . e($deleteUrl) . '" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['sender_details', 'subject_preview', 'action'])
                ->make(true);
        }

        return view('admin.contact-messages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        if (is_null($contactMessage->read_at)) {
            $contactMessage->markAsRead();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully!'
        ]);
    }

    /**
     * Get statistics for the dashboard cards.
     */
    public function stats()
    {
        $totalMessages = ContactMessage::count();
        $unreadMessages = ContactMessage::unread()->count();
        $todayMessages = ContactMessage::whereDate('created_at', today())->count();

        return response()->json([
            'total_messages' => $totalMessages,
            'unread_messages' => $unreadMessages,
            'today_messages' => $todayMessages,
        ]);
    }
}
