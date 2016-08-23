ALTER TABLE fbgame_year_variations ADD COLUMN id integer;
ALTER TABLE fbgame_year_variations ALTER COLUMN id SET NOT NULL;
ALTER TABLE fbgame_year_variations ALTER COLUMN id SET DEFAULT nextval('fbgame_year_variations_id_seq'::regclass);