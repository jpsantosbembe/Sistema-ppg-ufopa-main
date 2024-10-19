DROP TRIGGER IF EXISTS projeto_before_insert_trigger
    ON projetos;
DROP TRIGGER IF EXISTS projeto_before_update_trigger
    ON projetos;
DROP TRIGGER IF EXISTS categoria_docente_before_insert_trigger
    ON categorias_docentes;
DROP TRIGGER IF EXISTS categoria_docente_before_update_trigger
    ON categorias_docentes;

DROP FUNCTION IF EXISTS projeto_set_data_fim_func;
DROP FUNCTION IF EXISTS projeto_before_insert_trigger;
