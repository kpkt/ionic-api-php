
--
-- Database: `db_api`
--
CREATE DATABASE IF NOT EXISTS `db_api` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_api`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `telefon`) VALUES
(1, 'Nur Azyani bin Abdul Manaf', 'azyani@gmail.com', '0113456789'),
(2, 'Nurul Annisa Anuar', 'annisa@gmail.com', '0123456789'),
(3, 'Saifullah Poniman', 'saifullah@gmail.com', '0133456789'),
(4, 'Mohd Salleh Daim', 'salled.daim@gmail.com', '0143456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--