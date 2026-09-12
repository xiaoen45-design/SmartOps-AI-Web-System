-- Run this on database smartstay_php.
-- The three identity fields let SmartOps distinguish guests even when complaint text is identical.
ALTER TABLE smart_maintenance_tickets
  ADD COLUMN IF NOT EXISTS guest_phone VARCHAR(50) NULL AFTER room_id,
  ADD COLUMN IF NOT EXISTS guest_chat_id VARCHAR(150) NULL AFTER guest_phone,
  ADD COLUMN IF NOT EXISTS guest_message_id VARCHAR(255) NULL AFTER guest_chat_id,
  ADD COLUMN IF NOT EXISTS guest_start_notified_at DATETIME NULL AFTER guest_message_id,
  ADD COLUMN IF NOT EXISTS guest_notification_status VARCHAR(40) NULL AFTER guest_start_notified_at,
  ADD COLUMN IF NOT EXISTS guest_notification_error TEXT NULL AFTER guest_notification_status,
  ADD COLUMN IF NOT EXISTS guest_notification_method VARCHAR(40) NULL AFTER guest_notification_error,
  ADD COLUMN IF NOT EXISTS guest_notification_recipient VARCHAR(255) NULL AFTER guest_notification_method;

