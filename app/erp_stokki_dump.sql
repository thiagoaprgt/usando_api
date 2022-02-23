-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Fev-2022 às 19:25
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `erp_stokki`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

CREATE TABLE `arquivos` (
  `id` int(200) NOT NULL,
  `path` varchar(200) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_extension` varchar(200) NOT NULL,
  `id_pedidos` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `arquivos`
--

INSERT INTO `arquivos` (`id`, `path`, `file_name`, `file_extension`, `id_pedidos`) VALUES
(3, 'upload/xml/62165f921dddf.xml', 'teste.xml', 'xml', 1),
(4, 'upload/xml/6216605a76c6f.xml', 'teste.xml', 'xml', 3),
(5, 'upload/xml/62166473e6a7f.xml', 'teste.xml', 'xml', 1),
(6, 'upload/xml/621667c543da0.xml', 'teste.xml', 'xml', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notasficais`
--

CREATE TABLE `notasficais` (
  `number` int(200) NOT NULL,
  `series` int(200) DEFAULT NULL,
  `issue_at` datetime DEFAULT NULL,
  `key` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(200) NOT NULL,
  `rebate_discount` int(200) DEFAULT NULL,
  `rebate_token` varchar(200) DEFAULT NULL,
  `user_id` int(200) DEFAULT NULL,
  `updated_at` varchar(200) DEFAULT NULL,
  `tracking_code_list` int(200) DEFAULT NULL,
  `tracking_code` varchar(200) DEFAULT NULL,
  `total` int(200) DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `taxes` int(200) DEFAULT NULL,
  `subtotal` int(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  `payment_due_date` datetime DEFAULT NULL,
  `slip_url` varchar(200) DEFAULT NULL,
  `slip_token` varchar(200) DEFAULT NULL,
  `slip_due_date` datetime DEFAULT NULL,
  `slip` tinyint(1) DEFAULT NULL,
  `shipping_tracked_at` datetime DEFAULT NULL,
  `shipping_price` int(200) DEFAULT NULL,
  `shipping_label` varchar(200) DEFAULT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `payment_tid` varchar(200) DEFAULT NULL,
  `payment_method` varchar(200) DEFAULT NULL,
  `payment_gateway` varchar(200) DEFAULT NULL,
  `payment_authorization` varchar(200) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `items` int(200) DEFAULT NULL,
  `installments` int(200) DEFAULT NULL,
  `expected_delivery_date` datetime DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `discount_price` int(200) DEFAULT NULL,
  `deposit` tinyint(1) DEFAULT NULL,
  `delivery_type` varchar(200) DEFAULT NULL,
  `delivery_message` varchar(200) DEFAULT NULL,
  `delivery_days` int(200) DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `coupon_code` varchar(200) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `code` varchar(200) DEFAULT NULL,
  `client_id` int(200) DEFAULT NULL,
  `channel` varchar(200) DEFAULT NULL,
  `cart_id` int(200) DEFAULT NULL,
  `card_validity` varchar(200) DEFAULT NULL,
  `card_number` varchar(200) DEFAULT NULL,
  `card` tinyint(1) DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  `browser_ip` varchar(200) DEFAULT NULL,
  `agent` varchar(200) DEFAULT NULL,
  `affiliate_tag` varchar(200) DEFAULT NULL,
  `pix_qr_code` varchar(200) DEFAULT NULL,
  `payment_authorization_code` varchar(200) DEFAULT NULL,
  `bonus_granted` tinyint(1) DEFAULT NULL,
  `has_split` tinyint(1) DEFAULT NULL,
  `pix` tinyint(1) DEFAULT NULL,
  `ame_qr_code` varchar(200) DEFAULT NULL,
  `ame` tinyint(1) DEFAULT NULL,
  `antifraud_assurance` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `rebate_discount`, `rebate_token`, `user_id`, `updated_at`, `tracking_code_list`, `tracking_code`, `total`, `token`, `taxes`, `subtotal`, `status`, `payment_due_date`, `slip_url`, `slip_token`, `slip_due_date`, `slip`, `shipping_tracked_at`, `shipping_price`, `shipping_label`, `shipped_at`, `received_at`, `payment_tid`, `payment_method`, `payment_gateway`, `payment_authorization`, `paid_at`, `items`, `installments`, `expected_delivery_date`, `email`, `discount_price`, `deposit`, `delivery_type`, `delivery_message`, `delivery_days`, `delivered_at`, `coupon_code`, `confirmed_at`, `code`, `client_id`, `channel`, `cart_id`, `card_validity`, `card_number`, `card`, `canceled_at`, `browser_ip`, `agent`, `affiliate_tag`, `pix_qr_code`, `payment_authorization_code`, `bonus_granted`, `has_split`, `pix`, `ame_qr_code`, `ame`, `antifraud_assurance`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 300, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 'teste@email.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, 1200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, 'fulano@email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, 132, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, NULL, 'abc@email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, 432, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, 'wreq@email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(200) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `available` int(100) DEFAULT NULL,
  `category_tags` int(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `discount_id` int(200) DEFAULT NULL,
  `html_description` varchar(200) DEFAULT NULL,
  `image_url` varchar(200) DEFAULT NULL,
  `installments` int(200) DEFAULT NULL,
  `min_quantity` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `on_sale` tinyint(1) DEFAULT NULL,
  `plain_description` varchar(200) DEFAULT NULL,
  `price` int(200) DEFAULT NULL,
  `rating` int(200) DEFAULT NULL,
  `votes` int(200) DEFAULT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `sale_price` int(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `tag_names` int(200) DEFAULT NULL,
  `updated_at` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `variants` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `active`, `available`, `category_tags`, `description`, `discount_id`, `html_description`, `image_url`, `installments`, `min_quantity`, `name`, `on_sale`, `plain_description`, `price`, `rating`, `votes`, `reference`, `sale_price`, `slug`, `tag_names`, `updated_at`, `url`, `variants`) VALUES
(1, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'banana', NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL),
(2, NULL, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Laranja', NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL),
(3, NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Limão', NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'semente de Laranja', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedidos` (`id_pedidos`);

--
-- Índices para tabela `notasficais`
--
ALTER TABLE `notasficais`
  ADD PRIMARY KEY (`number`),
  ADD KEY `series` (`series`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `notasficais`
--
ALTER TABLE `notasficais`
  MODIFY `number` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `arquivos_ibfk_1` FOREIGN KEY (`id_pedidos`) REFERENCES `pedidos` (`id`);

--
-- Limitadores para a tabela `notasficais`
--
ALTER TABLE `notasficais`
  ADD CONSTRAINT `notasficais_ibfk_1` FOREIGN KEY (`series`) REFERENCES `pedidos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
