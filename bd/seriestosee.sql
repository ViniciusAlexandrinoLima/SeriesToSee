-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Jun-2021 às 02:41
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `seriestosee`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `users_id` int(11) UNSIGNED DEFAULT NULL,
  `series_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `reviews`
--

INSERT INTO `reviews` (`id`, `rating`, `review`, `users_id`, `series_id`) VALUES
(1, 8, 'Muito boa!', 3, 6),
(2, 5, 'Adorei!', 4, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `series`
--

CREATE TABLE `series` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `trailer` varchar(150) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `length` varchar(50) DEFAULT NULL,
  `users_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `series`
--

INSERT INTO `series` (`id`, `title`, `description`, `image`, `trailer`, `category`, `length`, `users_id`) VALUES
(1, 'Teste série xd', 'Essa série é muito boa', NULL, '', 'Drama', '1 temporada', 3),
(2, 'Teste Série dexter', 'A série é muito foda!!!', 'f6b5c97fc2393fc793b503ba39e6e7b8c10a45c489673f3a7cace94a91677710b7a8a23677f2b71bf02d14b2598bb82e72ce5ea1668728f8afaefe91.jpeg', 'https://www.youtube.com/embed/YQeUmSD1c3g', 'Fantasia', '8 temporadas', 3),
(3, 'Teste comédia', 'Uma série bem engraçada', NULL, '', 'Comédia', '1 temporada', 3),
(6, 'Teste Teste João', 'Testando', NULL, '', 'Policiais', '1 temporada', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `password`, `image`, `token`, `bio`) VALUES
(1, 'Teste', 'teste', 'teste@create.com', '$2y$10$voP0ldm9wgcyWyKp0rrAOuZYWkRbNqEq8d3EYpy2eZF3.s0inTJfO', NULL, '34a08d63ba35e28287bdb5a53f27d777f6ec1e2d85ff4e0ec1be41d3c0115de4cb2b6b670ad315ba43cb0cac05b281c388f4', NULL),
(2, 'Chama', NULL, NULL, '$2y$10$3birX95rTVYhrEMNZSXXFOG2BlbGmi3IvDux9RKVdTmaDrN/IwS8G', NULL, '781c2832a0c132f1b3b246007c84601be8a87575a801eb500a8a434d1385605fc493d5dc967a38ebff584f7f457a6d06814e', NULL),
(3, 'Wdson', 'Oliveira', 'augh-q@live.fr', '$2y$10$vK/854EQZm2FDyE9sdsJ/.fLLCLiyoRDRTgMMYwDfzUY.P8TYWoHO', 'da93b497dffc0e5c1cc299b0b24c74699d18ebcc53f29ded7909deade7cfa094184ee52afd4b2359c8039a9b36d64f22ae361b4f0bb6512c43f19833.jpg', 'f6ac028285879636c55d373b135bc39ca28cb0ab3693c058d442245e46426b17d3d284f37e08518303fac1a704ff4a20130a', 'Professor bonitão'),
(4, 'Joao', 'Henrique', 'joao@teste.com', '$2y$10$YdTgNtjScjJMJQeJ3eQwGOO3iej0tTxVqM.YOb39uLnCuWvvAyag6', NULL, 'd479aff5ff1c07a64e4f0dd17a65db7dd109d1403e66b3650251f6502edfaef6bb150d466ddf1204574183f67d5143531a2a', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Índices para tabela `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`);

--
-- Limitadores para a tabela `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
