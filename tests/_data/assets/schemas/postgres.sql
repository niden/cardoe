#drop schema tests;

drop table if exists tests.co_invoices;

create table tests.co_invoices
(
    inv_id          serial not null constraint co_invoices_pk primary key,
    inv_cst_id      integer,
    inv_status_flag smallint,
    inv_title       varchar,
    inv_total       numeric(10, 2),
    inv_created_at  date
);

alter table tests.co_invoices
    owner to postgres;

create index co_invoices_inv_created_at_index
    on tests.co_invoices (inv_created_at);

create index co_invoices_inv_cst_id_index
    on tests.co_invoices (inv_cst_id);

create unique index co_invoices_inv_id_uindex
    on tests.co_invoices (inv_id);

create index co_invoices_inv_status_flag_index
    on tests.co_invoices (inv_status_flag);

