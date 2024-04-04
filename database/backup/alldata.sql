CREATE OR REPLACE VIEW alldata AS
SELECT anak.nama, anak.nama_ibu, anak.nama_ayah, anak.jk, anak.tempat_lahir, 
anak.alamat, anak.tgl_lahir, data_anak.bln, data_anak.tb, data_anak.bb
FROM anak, data_anak 
where anak.id = data_anak.id_anak