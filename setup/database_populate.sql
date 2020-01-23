INSERT INTO tableOrder (name, password)
VALUES
    ('100', '100');

INSERT INTO admin (name, password)
VALUES
    ('adminPanelOrder', 'adminPasswordOrder');

INSERT INTO category (type)
VALUES
    ('Primo'),
    ('Secondo'),
    ('Dolci');

INSERT INTO food (name, price, id_category)
VALUES
    ('Pasta alla carbonara', '14','1'),
    ('Pasta in bianco', '14','1'),
    ('Carne di manzo', '14','2'),
    ('Crepes alla nutella', '14','3');