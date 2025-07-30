# SeeCut - Automatic Queue Management System

## Overview

The SeeCut platform now includes an intelligent automatic queue management system for vendors to efficiently handle customer reservations. This system automatically processes customers in order and sends email notifications at each status change.

## Key Features

### 1. Automatic Queue Processing
- **Smart Queue Order**: Customers are processed in the order they made reservations (FIFO - First In, First Out)
- **Auto-Progression**: When a customer's service is marked as "Finished", the next customer in queue is automatically moved to "Processing" status
- **Today-Only Focus**: Queue management focuses on reservations for the current day

### 2. Email Notifications
- **Instant Notifications**: Customers receive email notifications whenever their reservation status changes
- **Professional Templates**: Branded email templates with clear status information
- **Multi-Status Support**: Different email content based on status (Confirmed, Processing, Finished, Cancelled)

### 3. Queue Statistics Dashboard
- **Real-time Stats**: Live dashboard showing today's queue statistics
- **Status Breakdown**: Visual indicators for Total, Waiting, Processing, Finished, and Cancelled reservations
- **Auto-refresh**: Statistics update automatically every 30 seconds

## How It Works

### Starting the Day
1. Vendor clicks **"Mulai Hari Kerja"** (Start Day) button
2. System finds the first confirmed reservation for today
3. Customer status is changed to "Processing" 
4. Email notification is sent to the customer
5. Dashboard updates with current statistics

### During Service
1. When vendor completes a customer, they change status to "Finished"
2. System automatically finds the next customer in queue
3. Next customer's status is changed to "Processing"
4. Email notification is sent to the next customer
5. Vendor receives a notification about the next customer

### Manual Control
- **Call Next Customer**: Vendors can manually call the next customer using the "Panggil Berikutnya" button
- **Status Management**: Full control over individual reservation statuses
- **Override Capability**: Can manually manage queue if needed

## Email System

### Email Templates
The system uses professionally designed email templates that include:
- **Reservation Details**: ID, customer info, date, time
- **Status-Specific Messages**: Different content based on current status
- **Branding**: SeeCut branded emails with consistent styling
- **Call-to-Actions**: Relevant buttons and links for customers

### Email Content by Status

#### Processing Status
- **Subject**: "Update Status Reservasi SeeCut - Sedang Diproses"
- **Content**: Notification that it's their turn, preparation instructions
- **Tone**: Encouraging and informative

#### Confirmed Status  
- **Subject**: "Update Status Reservasi SeeCut - Dikonfirmasi"
- **Content**: Confirmation details and arrival instructions
- **Tone**: Professional and welcoming

#### Finished Status
- **Subject**: "Update Status Reservasi SeeCut - Selesai"
- **Content**: Thank you message and review request
- **Tone**: Appreciative and engaging

#### Cancelled Status
- **Subject**: "Update Status Reservasi SeeCut - Dibatalkan"
- **Content**: Cancellation notice and rebooking options
- **Tone**: Apologetic and helpful

## Technical Implementation

### Backend Components
- **VendorReservation.php**: Main Livewire component handling queue logic
- **ReservationStatusUpdated.php**: Mail class for email notifications
- **reservation-status-updated.blade.php**: Email template
- **Automatic Processing**: `processNextInQueue()` method
- **Statistics**: `getQueueStats()` method

### Database Integration
- Uses existing `reservations` table
- Leverages `reservation_slots` for date/time information
- No additional database changes required

### Error Handling
- **Email Failures**: System continues to work even if emails fail to send
- **Logging**: All email failures are logged for debugging
- **Graceful Degradation**: Queue processing continues regardless of email issues

## Usage Instructions

### For Vendors

1. **Start Your Day**
   - Click "Mulai Hari Kerja" when you begin work
   - First customer will be notified they're being processed

2. **Process Customers**
   - Change customer status to "Selesai" when service is complete
   - Next customer is automatically called and notified

3. **Monitor Queue**
   - Check the statistics dashboard for current queue status
   - Use filter buttons to view specific status groups

4. **Manual Override**
   - Use "Panggil Berikutnya" if you need to manually call next customer
   - Manually change any customer status as needed

### For Customers

1. **Receive Notifications**
   - Check email for status updates
   - Prepare when notified it's your turn

2. **Status Understanding**
   - **Dikonfirmasi**: Your reservation is confirmed, wait for your turn
   - **Sedang Diproses**: It's your turn! Come to the barbershop
   - **Selesai**: Service complete, thank you!
   - **Dibatalkan**: Reservation cancelled, please rebook if needed

## Configuration

### Email Settings
Configure email settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seecut.com
MAIL_FROM_NAME="SeeCut"
```

For development, you can use:
```env
MAIL_MAILER=log
```
This will log emails to `storage/logs/laravel.log` instead of sending them.

### Queue Refresh Rate
The dashboard statistics refresh every 30 seconds. To modify this, edit the JavaScript in the Blade template:

```javascript
// Change 30000 to desired milliseconds
setInterval(function() {
    Livewire.emit('refreshComponent');
}, 30000);
```

## Benefits

1. **Improved Customer Experience**: Customers know exactly when it's their turn
2. **Efficient Operations**: Automated queue management reduces vendor workload  
3. **Professional Communication**: Branded email notifications enhance brand image
4. **Reduced No-Shows**: Timely notifications help ensure customers arrive on time
5. **Data Insights**: Queue statistics help vendors understand busy periods
6. **Scalable System**: Works for barbershops of any size

## Future Enhancements

Potential future improvements could include:
- SMS notifications in addition to email
- Customer queue position tracking
- Estimated wait time calculations
- Integration with booking calendar
- Customer check-in system
- Queue analytics and reporting

---

*This queue management system is designed to streamline barbershop operations while maintaining excellent customer communication and service quality.*
