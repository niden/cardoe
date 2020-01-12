drop table if exists co_invoices;

create table tests.co_invoices
(
    inv_id          int identity constraint co_invoices_pk primary key nonclustered,
    inv_cst_id      int,
    inv_status_flag tinyint,
    inv_title       varchar(1),
    inv_total       numeric(10, 2),
    inv_created_at  datetime
)
go

create index co_invoices_inv_created_at_index
    on tests.co_invoices (inv_created_at)
go

create index co_invoices_inv_cst_id_index
    on tests.co_invoices (inv_cst_id)
go

create index co_invoices_inv_status_flag_index
    on tests.co_invoices (inv_status_flag)
go

