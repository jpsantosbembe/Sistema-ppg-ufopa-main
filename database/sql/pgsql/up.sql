-- Triggers para tabela 'projetos'
CREATE OR REPLACE FUNCTION projeto_set_data_fim_func()
RETURNS trigger AS $$
BEGIN
    IF NEW.situacao <> 'EM ANDAMENTO' THEN
        NEW.data_fim := NEW.data_situacao;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER projeto_before_insert_trigger
    BEFORE INSERT ON projetos
    FOR EACH ROW
EXECUTE PROCEDURE projeto_set_data_fim_func();

CREATE OR REPLACE TRIGGER projeto_before_update_trigger
    BEFORE UPDATE ON projetos
    FOR EACH ROW
EXECUTE PROCEDURE projeto_set_data_fim_func();

-- Triggers para tabela 'categorias_docentes'
CREATE OR REPLACE FUNCTION categoria_docente_set_ativo_func()
    RETURNS trigger AS $$
BEGIN
    IF NEW.data_fim IS NOT NULL THEN
        NEW.ativo := false;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER categoria_docente_before_insert_trigger
    BEFORE INSERT ON categorias_docentes
    FOR EACH ROW
EXECUTE PROCEDURE categoria_docente_set_ativo_func();

CREATE OR REPLACE TRIGGER categoria_docente_before_update_trigger
    BEFORE UPDATE ON categorias_docentes
    FOR EACH ROW
EXECUTE PROCEDURE categoria_docente_set_ativo_func();
