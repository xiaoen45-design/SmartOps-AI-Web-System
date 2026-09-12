-- Run this once on your existing smartstay_php database.
ALTER TABLE smart_maintenance_tickets
  ADD COLUMN guest_phone VARCHAR(50) NULL AFTER room_id,
  ADD COLUMN guest_chat_id VARCHAR(150) NULL AFTER guest_phone,
  ADD COLUMN guest_start_notified_at DATETIME NULL AFTER guest_chat_id,
  ADD COLUMN guest_notification_status VARCHAR(40) NULL AFTER guest_start_notified_at,
  ADD COLUMN guest_notification_error TEXT NULL AFTER guest_notification_status;
