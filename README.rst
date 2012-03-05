--- Database creation help 

 
--- trigger for fulltext:

CREATE FUNCTION lib_items_fts_update() RETURNS trigger AS $$
  DECLARE 
    cnt INTEGER;
BEGIN
-- test if row exists

    SELECT COUNT(*) INTO cnt FROM lib_items_fts WHERE id=NEW.id;
    IF cnt=0 THEN
        INSERT INTO lib_items_fts VALUES (NEW.id, '');
    END IF;
    UPDATE lib_items_fts set fts_index = 
         setweight(to_tsvector('czech', coalesce(NEW.name,'')), 'A') ||
         setweight(to_tsvector('czech', 
             coalesce(array_to_string(
                 array(SELECT string FROM lib_items_data WHERE item_id=NEW.id),' '),'')),'B') ||
         setweight(to_tsvector('czech', coalesce(NEW.note,'')), 'D') 
       WHERE id=NEW.id;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;
