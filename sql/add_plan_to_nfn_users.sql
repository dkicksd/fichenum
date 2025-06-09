ALTER TABLE nfn_users ADD COLUMN plan ENUM('free','premium') NOT NULL DEFAULT 'free';
