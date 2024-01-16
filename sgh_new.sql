CREATE DATABASE sgh_main;

use sgh_main;

CREATE TABLE item
(
	id INT NOT NULL AUTO_INCREMENT,
	kode VARCHAR(100) NOT NULL,
    nama VARCHAR(255) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE InnoDB;

CREATE TABLE kategori
(
	id INT NOT NULL AUTO_INCREMENT,
	nama VARCHAR(100) NOT NULL,
    toko VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) ENGINE InnoDB;

CREATE TABLE master_item
(
	id INT NOT NULL AUTO_INCREMENT,
    item_id INT NOT NULL,
    kategori_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY fk_item_master_item (item_id) REFERENCES item (id),
    FOREIGN KEY fk_kategori_master_item (kategori_id) REFERENCES kategori (id)
)ENGINE InnoDB;

CREATE TABLE transaksi_pembelian
(
	id INT NOT NULL AUTO_INCREMENT,
    master_item_id INT NOT NULL,
    supplier VARCHAR(100) NOT NULL,
    batch VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    sisa INT NOT NULL  DEFAULT 0,
    harga INT NOT NULL,
    tanggal BIGINT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY fk_master_item_transaksi_pembelian (master_item_id) REFERENCES master_item (id)
)ENGINE InnoDB;

CREATE TABLE limbah
(
	id INT NOT NULL AUTO_INCREMENT,
    transaksi_pembelian_id INT NOT NULL,
    jumlah INT NOT NULL,
    tanggal BIGINT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY fk_transaksi_pembelian_limbah (transaksi_pembelian_id) REFERENCES transaksi_pembelian (id)
) ENGINE InnoDB;

CREATE TABLE transaksi_penjualan
(
	id INT NOT NULL AUTO_INCREMENT,
    transaksi_pembelian_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    harga INT NOT NULL,
    tanggal BIGINT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY fk_transaksi_pembelian_transaksi_penjualan (transaksi_pembelian_id) REFERENCES transaksi_pembelian (id)
)ENGINE InnoDB;

CREATE TABLE produk
(
	id INT NOT NULL AUTO_INCREMENT,
    master_item_id INT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY fk_master_item_produk_view (master_item_id) REFERENCES master_item (id)
)ENGINE InnoDB;

CREATE TABLE transaksi_produk
(
	id INT NOT NULL AUTO_INCREMENT,
    produk_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    harga INT NOT NULL,
    tanggal BIGINT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY fk_produk_transaksi_produk (produk_id) REFERENCES produk (id)
)ENGINE InnoDB;

CREATE TABLE item_pengeluaran
(
	id VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
)ENGINE InnoDB;

CREATE TABLE pengeluaran
(
	id INT NOT NULL AUTO_INCREMENT,
	item_pengeluaran_id VARCHAR(100) NOT NULL,
    harga INT,
    tanggal BIGINT,
    PRIMARY KEY (id),
    FOREIGN KEY fk_item_pengeluaran_pengeluaran (item_pengeluaran_id) REFERENCES item_pengeluaran (id)
)ENGINE InnoDB;