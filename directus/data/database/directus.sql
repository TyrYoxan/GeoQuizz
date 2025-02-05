DROP TABLE IF EXISTS "Photo";
DROP SEQUENCE IF EXISTS "Photo_id_seq";
CREATE SEQUENCE "Photo_id_seq" INCREMENT MINVALUE  MAXVALUE  CACHE ;

CREATE TABLE "public"."Photo" (
                                  "id" integer DEFAULT nextval('"Photo_id_seq"') NOT NULL,
                                  "name" character varying(255),
                                  "lat" numeric(10,5),
                                  "long" numeric(10,5),
                                  "theme" json,
                                  "image" uuid,
                                  CONSTRAINT "Photo_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


ALTER TABLE ONLY "public"."Photo" ADD CONSTRAINT "photo_image_foreign" FOREIGN KEY (image) REFERENCES directus_files(id) ON DELETE SET NULL NOT DEFERRABLE;