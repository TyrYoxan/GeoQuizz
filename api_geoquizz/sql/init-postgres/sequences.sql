CREATE TABLE IF NOT EXISTS sequences(
    id_sequence CHAR(36) PRIMARY KEY DEFAULT (gen_random_uuid ()),
    name VARCHAR(255) NOT NULL,
    sequence VARCHAR(255) NOT NULL,
    status BOOL NOT NULL DEFAULT FALSE
);
INSERT INTO sequences (id_sequence, name, sequence, status) VALUES
    ('550e8400-e29b-41d4-a716-446655440000', 'Séquence Alpha', 'ATCGTAGCTAGCTAGC', TRUE),
    ('660e8400-e29b-41d4-a716-446655440001', 'Séquence Bêta', 'GCTAGCTAGCTAACGT', FALSE),
    ('770e8400-e29b-41d4-a716-446655440002', 'Séquence Gamma', 'TTGACCTGACGTTAGC', TRUE),
    ('880e8400-e29b-41d4-a716-446655440003', 'Séquence Delta', 'CAGTGCATGCTAGTCA', FALSE),
    ('990e8400-e29b-41d4-a716-446655440004', 'Séquence Epsilon', 'AGCTGATCGTAGCTAG', TRUE);