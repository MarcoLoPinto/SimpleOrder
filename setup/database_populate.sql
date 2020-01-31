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

INSERT INTO food (name, price, id_category, description)
VALUES
    ('Pasta alla carbonara', '14','1', 'Ottima pasta da mangiare e gustare insieme agli amici con un acqua'),
    ('Pasta alla amatriciana', '18','1', 'Ottima pasta da mangiare e gustare insieme a tutti, testo di prova per la lunghezza'),
    ('Pasta in bianco', '24','1','Ottima pasta (con poco e nulla, leggera) da mangiare e gustare insieme agli amici con un acqua'),
    ('Carne di manzo', '11','2',''),
    ('Carne di vitella', '11','2','La migliore sul mercato'),
    ('Crepes alla nutella', '23','3','Ottime crepes da mangiare e gustare insieme agli amici con un acqua'),
    ('Tiramisu', '12','3','Ottimo dolce da mangiare e gustare insieme agli amici con un acqua'),
    ('Torta cioccolato e panna', '11','3','Ottima torta da mangiare e gustare insieme agli amici con un acqua');
