create sequence person_seq;
create trigger person_trig before insert on persons for each row
begin
	:NEW.person_id := person_seq.NEXTVAL;
end;

create sequence record_seq;
create trigger record_trig before insert on radiology_record for each row
begin
	:NEW.record_id := record_seq.NEXTVAL;
end;

create sequence image_seq;
create trigger image_trig before insert on pacs_images for each row
begin
	:NEW.image_id := image_seq.NEXTVAL;
end;
