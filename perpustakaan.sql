CREATE DATABASE perpustakaan;
USE perpustakaan;

CREATE TABLE `admin`(
	`id_admin` INT AUTO_INCREMENT PRIMARY KEY,
	`username` VARCHAR(50) NOT NULL,
	`email` VARCHAR(100) NOT NULL,
	`password` VARCHAR(255) NOT NULL
);

CREATE TABLE `buku` (
	`id_buku` VARCHAR(10) PRIMARY KEY,
	`judul_buku` VARCHAR(100) NOT NULL,
	`pengarang` VARCHAR(100) NOT NULL,
	`penerbit` VARCHAR(100) NOT NULL,
	`tahun_terbit` YEAR NOT NULL,
	`views` INT NOT NULL DEFAULT 0
);

CREATE TABLE `pengguna` (
	`id_pengguna` VARCHAR(10) PRIMARY KEY,
	`nama_pengguna` VARCHAR(50) NOT NULL,
	`jenis_kelamin` ENUM('Laki - laki', 'Perempuan') NOT NULL,
	`alamat` VARCHAR(100) NOT NULL,
	`no_hp` VARCHAR(15) NOT NULL,
	`password` VARCHAR(255) NOT NULL
);

CREATE TABLE `peminjaman_buku` (
	`id_pinjam` INT AUTO_INCREMENT PRIMARY KEY,
	`id_buku` VARCHAR(10) NOT NULL,
	`id_pengguna` VARCHAR(10) NOT NULL,
	`tgl_peminjaman` DATE NOT NULL,
	`batas_waktu` DATE NOT NULL,
	`status` ENUM('Dipinjam', 'Dikembalikan') NOT NULL,
	FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
	FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna)
);

CREATE TABLE `pengembalian_buku` (
	`id_kembali` INT AUTO_INCREMENT PRIMARY KEY,
	`id_buku` VARCHAR(10) NOT NULL,
	`id_pengguna` VARCHAR(10) NOT NULL,
	`tgl_pengembalian` DATE NOT NULL,
	`terlambat` INT NOT NULL DEFAULT 0,
	`denda` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
	FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
	FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna)
);

CREATE TABLE `user_pengembalian_buku` (
	`id_kembali` INT AUTO_INCREMENT PRIMARY KEY,
	`id_buku` VARCHAR(10) NOT NULL,
	`id_pengguna` VARCHAR(10) NOT NULL,
	`tgl_pengembalian` DATE NOT NULL,
	`terlambat` INT NOT NULL DEFAULT 0,
	`denda` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
	`deleted` TINYINT(1) NOT NULL DEFAULT 0,
	FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
	FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna)
);

INSERT INTO buku (id_buku, judul_buku, pengarang, penerbit, tahun_terbit) VALUES
('A001', 'Python Programming', 'John Smith', 'TechPress', 2022),
('A002', 'JavaScript Essentials', 'Douglas Crockford', 'O\'Reilly Media', 2021),
('A003', 'Clean Code', 'Robert C. Martin', 'Prentice Hall', 2019),
('A004', 'The Pragmatic Programmer', 'Andrew Hunt', 'Addison-Wesley', 2018),
('A005', 'Design Patterns', 'Erich Gamma', 'Addison-Wesley', 2020),
('A006', 'Java Complete Reference', 'Herbert Schildt', 'McGraw-Hill', 2023),
('A007', 'Effective Java', 'Joshua Bloch', 'Addison-Wesley', 2019),
('A008', 'Head First Patterns', 'Eric Freeman', 'O\'Reilly Media', 2021),
('A009', 'PHP Patterns', 'Mika Schwartz', 'Apress', 2022),
('A010', 'Learning SQL', 'Alan Beaulieu', 'O\'Reilly Media', 2018),
('A011', 'SQL Explained', 'Marcus Winand', 'Leanpub', 2021),
('A012', 'Java Basics', 'James K. Cooper', 'Packt Publishing', 2020),
('A013', 'HTML & CSS', 'Jon Duckett', 'Wiley', 2021),
('A014', 'JavaScript Guide', 'David Flanagan', 'O\'Reilly Media', 2019),
('A015', 'Machine Learning', 'Shai Shalev-Shwartz', 'Cambridge University Press', 2022);