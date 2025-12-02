# Notification System - How It Works

## Overview
The Cleanify application uses Laravel's built-in notification system to send notifications to users about various events in the system.

## Architecture

### 1. Database Structure
- **Table**: `notifications` (Laravel's default notifications table)
  - `id` (UUID)
  - `type` (Notification class name)
  - `notifiable_type` (User model)
  - `notifiable_id` (User ID)
  - `data` (JSON - notification content)
  - `read_at` (timestamp - when notification was read)
  - `created_at`, `updated_at`

### 2. User Model Integration
- User model uses `Notifiable` trait (Laravel's built-in)
- This provides methods like:
  - `$user->notify($notification)` - Send notification
  - `$user->notifications()` - Get all notifications
  - `$user->unreadNotifications()` - Get unread notifications

### 3. Notification Classes
Located in `app/Notifications/`:
- `ScheduleCreatedNotification` - When admin creates a new schedule
- `ReportResolvedNotification` - When admin resolves a report
- `ReportRejectedNotification` - When admin rejects a report
- `TestEmailNotification` - For testing email functionality

## How Notifications Are Created

### Example 1: Report Resolved
```php
// In Admin/ReportsController.php
$report->user->notify(new ReportResolvedNotification($report));
```

**Flow:**
1. Admin resolves a report
2. Controller calls `notify()` on the report owner
3. Notification class checks if user has email notifications enabled
4. If enabled, sends email via `toMail()` method
5. Always stores notification in database via `toArray()` method

### Example 2: Report Rejected
```php
// In Admin/ReportsController.php
$report->user->notify(new ReportRejectedNotification($report));
```

**Flow:**
1. Admin rejects a report
2. Notifies the report owner
3. Also notifies all followers of the report (if they have email notifications enabled)

### Example 3: Schedule Created
```php
// When admin creates a schedule
// Users in that area should be notified
// (Currently not fully implemented - needs to be added)
```

## Notification Data Structure

Each notification stores data in JSON format:
```json
{
  "report_id": 123,
  "status": "resolved",
  "location": "Zone 1",
  "category": "reports",
  "title": "Your report is resolved",
  "message": "Location: Zone 1",
  "icon": "fa-check-circle",
  "color": "bg-green-600",
  "url": "/community-reports"
}
```

## Delivery Channels

### 1. Database (Always)
- All notifications are stored in the `notifications` table
- Accessible via the notifications page
- Can be marked as read/unread

### 2. Email (Conditional)
- Only sent if `$user->email_notifications === true`
- Uses Laravel's Mail system
- Formatted using `MailMessage` class

### 3. SMS (Not Implemented)
- Placeholder exists in user model
- Would require SMS service integration

### 4. Push (Not Implemented)
- Placeholder exists in user model
- Would require push notification service

## Notification Categories

The system supports 5 categories:
1. **schedule** - Schedule & Routes
2. **tracker** - Truck Tracker
3. **reports** - Reports & Community
4. **community** - Community Activity
5. **system** - System Alerts

## User Preferences

### Global Preferences
- `email_notifications` (boolean) - Enable/disable all email notifications
- `sms_notifications` (boolean) - Enable/disable SMS (not implemented)
- `push_notifications` (boolean) - Enable/disable push (not implemented)

### Category Preferences
- `notification_preferences` (JSON) - Per-category preferences
  ```json
  {
    "schedule": true,
    "tracker": true,
    "reports": true,
    "community": false,
    "system": true
  }
  ```

## How Users View Notifications

### 1. Notification Page (`/notifications`)
- Lists all notifications
- Filters: All/Unread
- Category filter
- Include muted categories option
- Mark as read functionality
- Dismiss (delete) functionality

### 2. Notification Display
- Shows icon, title, message
- Color-coded by category
- Timestamp (relative: "2 hours ago")
- Action URL (if available)
- Status badge (Unread/Read)

## Current Implementation Status

### ✅ Fully Working
- Database notifications storage
- Notification display page
- Mark as read/unread
- Category filtering
- User preferences management
- Email notifications for reports (resolved/rejected)
- Schedule notifications (triggered when schedule is created/updated)
- Report notifications (resolved/rejected) - both database and email
- Category preferences filtering

### ❌ Not Implemented
- SMS notifications
- Push notifications
- Real-time notification updates (would need WebSockets)
- Notification badges in navigation

## How to Add New Notifications

### Step 1: Create Notification Class
```bash
php artisan make:notification YourNotificationName
```

### Step 2: Implement Methods
```php
public function via($notifiable) {
    // Return channels: ['mail', 'database']
}

public function toMail($notifiable) {
    // Email content
}

public function toArray($notifiable) {
    // Database content
    return [
        'title' => 'Notification Title',
        'message' => 'Notification message',
        'category' => 'reports',
        'icon' => 'fa-icon',
        'color' => 'bg-green-600',
        'url' => '/some-url',
    ];
}
```

### Step 3: Send Notification
```php
$user->notify(new YourNotificationName($data));
```

## Example: Adding Schedule Notification

Currently, when admin creates a schedule, users are NOT automatically notified. To add this:

1. In `Admin/ScheduleController@store`:
```php
// After creating schedule
$users = User::where('service_area', $schedule->area)
    ->where('email_notifications', true)
    ->get();

foreach ($users as $user) {
    $user->notify(new ScheduleCreatedNotification($schedule));
}
```

2. Update `ScheduleCreatedNotification@toArray` to include category:
```php
return [
    'schedule_id' => $this->schedule->id,
    'area' => $this->schedule->area,
    'status' => $this->schedule->status,
    'category' => 'schedule',
    'title' => 'New schedule for your area',
    'message' => 'Area: ' . $this->schedule->area,
    'icon' => 'fa-calendar',
    'color' => 'bg-blue-600',
    'url' => url('/garbage-schedule'),
];
```

## Notification Flow Diagram

```
Event Occurs (e.g., Report Resolved)
    ↓
Controller calls $user->notify()
    ↓
Notification Class checks via() method
    ↓
If email enabled → Send Email (toMail)
    ↓
Always → Store in Database (toArray)
    ↓
User sees notification in /notifications page
    ↓
User can mark as read or dismiss
```

## Key Features

1. **Automatic Storage**: All notifications automatically stored in database
2. **Email Integration**: Optional email sending based on user preferences
3. **Category System**: Organize notifications by type
4. **User Control**: Users can mute categories, mark as read, dismiss
5. **Filtering**: Search and filter notifications
6. **Real-time Count**: Unread count displayed in UI

