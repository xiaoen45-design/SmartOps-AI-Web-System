-- Run once on your existing smartstay_php database.
-- This stores the original inbound WhatsApp message so the bot can reply to
-- the exact complaint conversation when the technician accepts the case.
ALTER TABLE smart_maintenance_tickets
  ADD COLUMN guest_message_id VARCHAR(255) NULL AFTER guest_chat_id;
