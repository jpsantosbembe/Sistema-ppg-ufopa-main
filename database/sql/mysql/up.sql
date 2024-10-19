DROP TRIGGER IF EXISTS projetos_BEFORE_INSERT;
CREATE DEFINER = CURRENT_USER TRIGGER projetos_BEFORE_INSERT BEFORE INSERT ON projetos FOR EACH ROW
BEGIN
    IF NEW.situacao <> 'EM ANDAMENTO' THEN
       SET NEW.data_fim = NEW.data_situacao;
    END IF;
END;

DROP TRIGGER IF EXISTS projetos_BEFORE_UPDATE;
CREATE DEFINER = CURRENT_USER TRIGGER projetos_BEFORE_UPDATE BEFORE UPDATE ON projetos FOR EACH ROW
BEGIN
    IF NEW.situacao <> 'EM ANDAMENTO' THEN
       SET NEW.data_fim = NEW.data_situacao;
    END IF;
END;

DROP TRIGGER IF EXISTS categorias_docentes_BEFORE_INSERT;
CREATE DEFINER = CURRENT_USER TRIGGER categorias_docentes_BEFORE_INSERT BEFORE INSERT ON categorias_docentes FOR EACH ROW
BEGIN
    IF NEW.data_fim IS NOT NULL THEN
        SET NEW.ativo = 0;
    END IF;
END;

DROP TRIGGER IF EXISTS categorias_docentes_BEFORE_UPDATE;
CREATE DEFINER = CURRENT_USER TRIGGER categorias_docentes_BEFORE_UPDATE BEFORE UPDATE ON categorias_docentes FOR EACH ROW
BEGIN
    IF NEW.data_fim IS NOT NULL THEN
        SET NEW.ativo = 0;
    END IF;
END;

DROP PROCEDURE IF EXISTS `get_vinculos_by_codigo`;
CREATE PROCEDURE get_vinculos_by_codigo(IN codigo_pessoa INT)
BEGIN
    SELECT 	v.id, v.vinculavel_type, v.vinculavel_id, COALESCE(vdo.codigo_vinculavel, vpo.codigo_vinculavel, vex.codigo_vinculavel, vdi.codigo_vinculavel, veg.codigo_vinculavel) as codigo_vinculavel
    FROM pessoas as p
             INNER JOIN vinculos as v
                        ON p.id = v.id_pessoa

             LEFT OUTER JOIN vinculos_docentes vdo ON (v.vinculavel_id = vdo.id AND v.vinculavel_type = 'App\\Models\\VinculoDocente')
             LEFT OUTER JOIN vinculos_pos_doc vpo ON (v.vinculavel_id = vpo.id AND v.vinculavel_type = 'App\\Models\\VinculoPosDoc')
             LEFT OUTER JOIN vinculos_externos vex ON (v.vinculavel_id = vex.id AND v.vinculavel_type = 'App\\Models\\VinculoExterno')
             LEFT OUTER JOIN vinculos_discentes vdi ON (v.vinculavel_id = vdi.id AND v.vinculavel_type = 'App\\Models\\VinculoDiscente')
             LEFT OUTER JOIN vinculos_egressos veg ON (v.vinculavel_id = veg.id AND v.vinculavel_type = 'App\\Models\\VinculoEgresso')

    WHERE p.codigo_pessoa = codigo_pessoa;
END
