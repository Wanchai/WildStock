CREATE TABLE fbgame_news
(
  id serial NOT NULL,
  text text,
  created date,
  tweet bigint,
  CONSTRAINT fbgame_news_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);

ALTER TABLE fbgame_offers ADD COLUMN stock_name character varying(100);

ALTER TABLE fbgame_transactions ADD COLUMN stock_name character varying;

UPDATE fbgame_transactions SET stock_name = subquery.name
FROM (SELECT name
      FROM  fbgame_stocks WHERE id = fbgame_transactions.stock_id) AS subquery
;

UPDATE fbgame_offers SET stock_name = subquery.name
FROM (SELECT name
      FROM  fbgame_stocks WHERE id = fbgame_offers.stock_id) AS subquery
;

ALTER TABLE fbgame_offers ADD COLUMN bought double precision;

UPDATE fbgame_offers SET bought = subquery.value
FROM (SELECT value 
      FROM  fbgame_stocks WHERE id = fbgame_offers.stock_id) AS subquery
;

# Change la valeur d'auto-incrementation

SELECT setval('public.fbgame_books_id_seq', 500, true);
SELECT setval('public.fbgame_offers_id_seq', 500, true);
SELECT setval('public.fbgame_fbrequests_id_seq', 500, true);
SELECT setval('public.fbgame_friends_id_seq', 500, true);
SELECT setval('public.fbgame_stocks_id_seq', 500, true);
SELECT setval('public.fbgame_transactions_id_seq', 500, true);
SELECT setval('public.fbgame_users_id_seq', 500, true);

CREATE TABLE fbgame_config
(
  name character varying,
  value character varying
)

INSERT INTO fbgame_config(
            name, value)
    VALUES ('maintenance', '0');

INSERT INTO fbgame_config(
            name, value)
    VALUES ('version', '0.1');

UPDATE fbgame_offers SET type = type+1;

UPDATE fbgame_offers SET type = 1 WHERE type = 3;

ALTER TABLE fbgame_users ADD COLUMN like_page boolean;
ALTER TABLE fbgame_users ALTER COLUMN like_page SET DEFAULT false;

