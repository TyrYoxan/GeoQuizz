DROP TABLE IF EXISTS "parties";
CREATE TABLE IF NOT EXISTS parties(
    id_partie CHAR(36) PRIMARY KEY DEFAULT (gen_random_uuid ()),
    sequence_photo CHAR(36) NOT NULL,
    score INTEGER NOT NULL,
    CONSTRAINT fk_sequence
        FOREIGN KEY (sequence_photo)
            REFERENCES sequences(id_sequence)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);
INSERT INTO parties (sequence_photo, score) VALUES
    ('550e8400-e29b-41d4-a716-446655440000', 85),
    ('660e8400-e29b-41d4-a716-446655440001', 92),
    ('770e8400-e29b-41d4-a716-446655440002', 78),
    ('880e8400-e29b-41d4-a716-446655440003', 88),
    ('990e8400-e29b-41d4-a716-446655440004', 95);
