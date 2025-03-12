DO $$
BEGIN
  -- Verifica se o banco de dados filter_db existe e cria se necessário
  IF NOT EXISTS (SELECT 1 FROM pg_database WHERE datname = 'filter_db') THEN
    CREATE DATABASE filter_db;
  END IF;

  -- Verifica se a extensão dblink está instalada e instala se necessário
  IF NOT EXISTS (SELECT 1 FROM pg_extension WHERE extname = 'dblink') THEN
    CREATE EXTENSION dblink;
  END IF;

  -- Conecta ao banco de dados filter_db e executa os comandos
  PERFORM dblink_exec('dbname=filter_db', $$
    -- Instala a extensão unaccent
    CREATE EXTENSION IF NOT EXISTS unaccent;
  $$);

END $$;