DROP TABLE IF EXISTS "parties";
CREATE TABLE IF NOT EXISTS parties(
    id_partie CHAR(36) PRIMARY KEY DEFAULT (gen_random_uuid ()),
    sequence_photo CHAR(36) NOT NULL,
    id_user CHAR(36) NOT NULL,
    score INTEGER NOT NULL,
    CONSTRAINT fk_sequence
        FOREIGN KEY (sequence_photo)
            REFERENCES sequences(id_sequence)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);
INSERT INTO parties (sequence_photo,id_user, score) VALUES
    ('550e8400-e29b-41d4-a716-446655440000','5c068da4-a480-4dd7-828c-9bfda2d608fd', 85),
    ('660e8400-e29b-41d4-a716-446655440001','5c068da4-a480-4dd7-828c-9bfda2d608fd', 92),
    ('770e8400-e29b-41d4-a716-446655440002','5c068da4-a480-4dd7-828c-9bfda2d608fd', 78),
    ('880e8400-e29b-41d4-a716-446655440003','5c068da4-a480-4dd7-828c-9bfda2d608fd', 88),
    ('990e8400-e29b-41d4-a716-446655440004','5c068da4-a480-4dd7-828c-9bfda2d608fd', 95);
