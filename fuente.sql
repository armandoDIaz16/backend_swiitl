
CREATE TABLE CAT_FUENTE(
                           PK_FUENTE INT NOT NULL IDENTITY ,
                           NOMBRE_FAMILY VARCHAR(100),
                           NOMBRE_STYLE_NORMAL VARCHAR(100),
                           NOMBRE_STYLE_BOLD VARCHAR(100),
                           NOMBRE_STYLE_ITALIC VARCHAR(100)
);

INSERT INTO
    CAT_FUENTE (NOMBRE_FAMILY, NOMBRE_STYLE_NORMAL, NOMBRE_STYLE_BOLD, NOMBRE_STYLE_ITALIC)
VALUES
('montserrat','Montserrat-Medium','Montserrat-ExtraBold','Montserrat-ExtraLightItalic');

