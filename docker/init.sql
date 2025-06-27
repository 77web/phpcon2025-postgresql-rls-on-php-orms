drop policy if exists users_policy_tenant on users;
drop policy if exists members_policy_tenant on members;
drop schema public cascade;
create schema public;

create table migrations (
    id serial,
    migration text,
    batch text
);

create role "tenant";
grant usage on schema public to "tenant";

create table users (
    id serial primary key,
    name text,
    password text,
    email text,
    created_at timestamp,
    updated_at timestamp
);
create policy users_policy_tenant on users to "tenant"
    using (email = current_user::text);
grant all on table "users" to "tenant";
alter table "users" enable row level security;

create table members(
    id serial primary key,
    user_id integer,
    name text,
    created_at timestamp,
    updated_at timestamp
);
alter table members add constraint fk_user_id foreign key (user_id) references users (id);
create policy members_policy_tenant on members to "tenant"
    using (user_id in (select id from users where email = current_user::text));
grant all on table "members" to "tenant";
alter table "members" enable row level security;
