-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 10, 2021 at 10:11 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `site_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussion_likes`
--

CREATE TABLE `discussion_likes` (
  `like_id` int(11) NOT NULL,
  `liked_by` int(100) NOT NULL,
  `p_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discussion_likes`
--

INSERT INTO `discussion_likes` (`like_id`, `liked_by`, `p_id`) VALUES
(4, 20, 59),
(5, 23, 60),
(40, 26, 62),
(41, 26, 64),
(42, 23, 62),
(43, 23, 63),
(44, 23, 64),
(45, 23, 65),
(46, 25, 63),
(47, 25, 62),
(48, 24, 62),
(49, 24, 65),
(50, 24, 63),
(51, 23, 54),
(52, 23, 67),
(53, 20, 67),
(54, 24, 67),
(55, 25, 67);

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `u_id` int(100) NOT NULL,
  `subject` varchar(60) NOT NULL,
  `message` varchar(6000) NOT NULL,
  `img1_id` int(100) NOT NULL,
  `img2_id` int(100) NOT NULL,
  `img3_id` int(100) NOT NULL,
  `post_date` datetime NOT NULL,
  `item_id` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`post_id`, `u_id`, `subject`, `message`, `img1_id`, `img2_id`, `img3_id`, `post_date`, `item_id`) VALUES
(54, 20, 'this is a lovely tea cup', 'abcdefg', 0, 0, 0, '2021-04-08 22:32:21', 10),
(59, 20, 'this is a lovely cup.', 'This is for my morning coffee cup. lovely colour and very sturdy!', 8, 9, 0, '2021-04-08 23:30:29', 15),
(60, 20, 'chic and modern', 'I love Teema line. highly recommended!  ', 0, 0, 0, '2021-04-08 23:50:16', 11),
(61, 23, 'I have this one, too.', 'cooooooool hehe', 0, 0, 0, '2021-04-08 23:59:07', 11),
(62, 20, 'this is a lovely tea cup', 'Ideal size for a cup of tea.\r\nClassic white porcelain and shape', 0, 0, 0, '2021-04-09 21:41:38', 12),
(63, 23, 'classic', 'only for special occasion ', 0, 0, 0, '2021-04-09 21:42:54', 12),
(64, 24, 'Tea cup review ', ':-) ', 0, 0, 0, '2021-04-09 21:57:48', 12),
(65, 25, 'this is test.', 'perfection!', 0, 0, 0, '2021-04-09 21:59:24', 12),
(67, 26, 'My favorite!', 'The Owl telling me \"come and grab the cup and sip tea with me!\" ', 11, 12, 0, '2021-04-10 21:29:49', 10);

-- --------------------------------------------------------

--
-- Table structure for table `forum_images`
--

CREATE TABLE `forum_images` (
  `fi_id` int(100) NOT NULL,
  `image_src` varchar(500) NOT NULL,
  `u_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forum_images`
--

INSERT INTO `forum_images` (`fi_id`, `image_src`, `u_id`, `product_id`) VALUES
(8, 'uploads/teacora-rooibos-cOWE5cctcZI-unsplash.jpg', 20, 15),
(9, 'uploads/loverna-journey-3Nkvga0rH6I-unsplash.jpg', 20, 15),
(11, 'uploads/sixteen-miles-out-SvbDNnbipj0-unsplash.jpg', 26, 10),
(12, 'uploads/brigitte-tohm-EAay7Aj4jbc-unsplash.jpg', 26, 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `order_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total`, `order_date`) VALUES
(11, 20, '85.00', '2021-04-08 23:27:21'),
(10, 20, '95.00', '2021-04-08 22:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `order_contents`
--

CREATE TABLE `order_contents` (
  `content_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `price` decimal(4,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_contents`
--

INSERT INTO `order_contents` (`content_id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(2, 10, 12, 1, '95.00'),
(3, 11, 9, 1, '85.00');

-- --------------------------------------------------------

--
-- Table structure for table `product_rates`
--

CREATE TABLE `product_rates` (
  `rate_id` int(11) NOT NULL,
  `item_id` int(100) NOT NULL,
  `rate` int(10) NOT NULL,
  `rated_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_rates`
--

INSERT INTO `product_rates` (`rate_id`, `item_id`, `rate`, `rated_by`) VALUES
(10, 10, 5, 20),
(16, 15, 5, 20),
(17, 11, 5, 20),
(18, 11, 5, 23),
(19, 12, 5, 20),
(20, 12, 3, 23),
(21, 12, 4, 24),
(22, 12, 5, 25),
(24, 10, 5, 26);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `item_id` int(10) UNSIGNED NOT NULL,
  `item_category` varchar(20) NOT NULL,
  `item_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `item_desc` varchar(400) CHARACTER SET utf8 NOT NULL,
  `item_img1` varchar(100) CHARACTER SET utf8 NOT NULL,
  `item_img2` varchar(100) CHARACTER SET utf8 NOT NULL,
  `item_price` decimal(4,2) NOT NULL,
  `item_spec` varchar(600) CHARACTER SET utf8 NOT NULL,
  `options_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`item_id`, `item_category`, `item_name`, `item_desc`, `item_img1`, `item_img2`, `item_price`, `item_spec`, `options_id`) VALUES
(10, 'CoffeeCup', 'Taika espresso cup', 'Designer Klaus Haapaniemi’s lively art and Heikki Orvola’s streamlined design combine to create Taika (‘magic’ in Finnish).', 'assets/images/iittala-nightowl-1.jpeg', '', '65.00', '<dl class=\"d-flex flex-column justify-content-between\">\r\n<dt class=\"\">volume</dt>\r\n<dd>100ml</dd>\r\n<dt>feature</dt>\r\n<dd>An enchanted collection that brings folklore and fairy tales alive through functional, simple design. A cast of colourful characters inspire imagination and storytelling in the everyday with versatile, durable porcelain tableware that fits any table setting.</dd>\r\n</dl>', 0),
(6, 'TeaCup', 'Wonderlust Rococo Flowers Teacup and Saucer', 'beautifully feminine florals create an elegant look to the Wanderlust Rococo Bowl Teacup and Saucer. Crafted from fine bone china. this duo features a subtle yet stylish geometric backdrop to accentuate the rococo inspired chinoiserie detail. Presented in a wedgwood blue gift box.', 'assets/images/wedgwood-rococo-1.jpeg', 'assets/images/wedgwood-rococo-2.jpeg', '55.00', '<dl>\r\n<dt>weight</dt>\r\n<dd>310g</dd>\r\n<dt>volume</dt>\r\n<dd>150ml</dd>\r\n<dt>features</dt>\r\n<dd>Mixed colour with stunning Gold banding for that extra special touch</dd>\r\n<dd>Featuring a beautiful Ornamental, Expressive pattern</dd>\r\n</dl>', 2),
(7, 'TeaCup', 'Wonderlust Midnight Crane Teacup and Saucer', 'The Wonderlust Midnight Crane Teacup & Saucer is crafted from fine bone china and features Chinoiserie styled bird and florals contrasting against a rich scroll backdrop. Presented in a Wedgwood blue gift box and ideal with your favourite tea blends.', 'assets/images/wedgwood-midnight-1.jpeg', 'assets/images/wedgwood-midnight-2.jpeg', '50.00', '<dl>\r\n<dt>weight</dt>\r\n<dd>300g</dd>\r\n<dt>volume</dt>\r\n<dd>150ml</dd>\r\n<dt>features</dt>\r\n<dd>Blue is the main colour of this item with stunning Gold banding for that extra special touch </dd>\r\n<dd>Featuring a beautiful Ornamental, Expressive pattern</dd>\r\n</dl>', 2),
(8, 'Mug', 'Annual Easter Edition mug 2021', 'The Annual Easter Edition makes the hearts of collectors and decoration lovers beat faster – these limited edition favourites have a gold stamp on the base, are only available in the year of issue and come in a beautiful gift box. The ideal Easter present for your loved ones or for yourself. ', 'assets/images/vb-eastermug-1.jpeg', 'assets/images/vb-eastermug-2.jpeg', '35.00', '<dl>\r\n<dt>weight</dt>\r\n<dd>approx. 316g</dd>\r\n<dt>volume</dt>\r\n<dd>approx. 380ml</dd>\r\n</dl>', 0),
(9, 'CoffeeCup', 'Anmut cappuccino cup\r\n', 'True classic: breakfast cups from Villeroy & Boch\r\n', 'assets/images/vb-anmut-cappuccino-1.jpeg', '', '85.00', '<dl>\r\n<dt>weight</dt>\r\n<dd>approx. 190g</dd>\r\n<dt>volume</dt>\r\n<dd>approx. 400ml</dd>\r\n<dt>feature</dt>\r\n<dd>Timeless gracefulness and playful charm – the Villeroy & Boch Anmut collection offers all that and more. Inspired by designs from the fifties. Opt for graceful and attractive lines for breakfast or afternoon coffee. Impress your guests with this high-quality item.</dd>\r\n</dl>', 0),
(11, 'Mug', 'Teema mug grey', 'Designed by one of Iittala’s most pioneering design heroes, Kaj Franck', 'assets/images/iittala-teema-1.jpeg', 'assets/images/iittala-teema-2.jpeg', '80.00', '<dl>\r\n<dt>colour</dt>\r\n<dd>grey</dd>\r\n<dt>volume</dt>\r\n<dd>300ml</dd>\r\n<dt>feature</dt>\r\n<dd>A versatile collection with endless combinations that are functional, durable and refined. It’s what one uses them for that makes it theirs. Teema is a classic icon of minimalist Nordic design.</dd>\r\n<dd>The Teema mug’s generous size makes it perfect for enjoying a favourite hot beverage like tea, coffee or latte. White brings clean sophistication to any table setting. Mix and match with the same colour or other colours in the Teema collection. Collect a set.\r\n</dd>\r\n</dl>', 1),
(12, 'TeaCup', 'Herend Fish Scale Teacup', 'Produced in the Hungary exclusively for Fortnum & Mason', 'assets/images/herendfishscale-1.jpeg', '', '95.00', '<dl>\r\n<dt>Dimensions</dt>\r\n<dd>5cm(H) x 11cm(W) x 9cm(D)</dd>\r\n<dt>volume</dt>\r\n<dd>200ml</dd>\r\n<dt>feature</dt>\r\n<dd>this elegant teacup is crafted from fine white porcelain and features Herend’s signature Fish Scale pattern.</dd>\r\n<dd>Individually hand-painted in Fortnum’s Eau de Nil and finished with 24 carat accents, it makes an elegant addition to your Afternoon Tea experience, or as a gift for a tea lover.\r\n</dd>\r\n</dl>', 0),
(13, 'Tea Cup', 'Rory Dobner Teacup & Saucer', 'Alice In Wonderland Cheshire Cat', 'assets/images/cheshirecat-1.jpeg', 'assets/images/cheshirecat-2.jpeg', '95.00', '<dl>\r\n<dt>Dimensions</dt>\r\n<dd>5.7cm(H) x 8.4cm(W) x 6cm(D)</dd>\r\n<dt>volume</dt>\r\n<dd>190ml</dd>\r\n<dt>feature</dt>\r\n<dd>Made in England exclusively for Fortnum\'s, this Alice In Wonderland Cheshire Cat Teacup & Saucer is crafted from delicate fine bone china, and finished with a hand-painted illustration and 22-carat gold detailing. Simple, yet intricately detailed, it is perfect for teatime sipping.\r\n</dd>\r\n</dl>', 0),
(14, 'Mug', 'Teema mug yellow', 'Designed by one of Iittala’s most pioneering design heroes, Kaj Franck', 'assets/images/teema-yellow-1.jpeg', 'assets/images/teema-yellow-2.jpeg', '80.00', '<dl>\r\n<dt>colour</dt>\r\n<dd>yellow</dd>\r\n<dt>volume</dt>\r\n<dd>300ml</dd>\r\n<dt>feature</dt>\r\n<dd>A versatile collection with endless combinations that are functional, durable and refined. It’s what one uses them for that makes it theirs. Teema is a classic icon of minimalist Nordic design.</dd>\r\n<dd>The Teema mug’s generous size makes it perfect for enjoying a favourite hot beverage like tea, coffee or latte. White brings clean sophistication to any table setting. Mix and match with the same colour or other colours in the Teema collection.\r\n</dd>\r\n</dl>', 1),
(15, 'Mug', 'Teema mug pink', 'Designed by one of Iittala’s most pioneering design heroes, Kaj Franck', 'assets/images/teema-pink-1.jpeg', 'assets/images/teema-pink-2.jpeg', '80.00', '<dl>\r\n<dt>colour</dt>\r\n<dd>pink</dd>\r\n<dt>volume</dt>\r\n<dd>300ml</dd>\r\n<dt>feature</dt>\r\n<dd>A versatile collection with endless combinations that are functional, durable and refined. It’s what one uses them for that makes it theirs. Teema is a classic icon of minimalist Nordic design.</dd>\r\n<dd>The Teema mug’s generous size makes it perfect for enjoying a favourite hot beverage like tea, coffee or latte. White brings clean sophistication to any table setting. Mix and match with the same colour or other colours in the Teema collection.\r\n</dd>\r\n</dl>', 1),
(16, 'TeaCup', 'Whittard English Breakfast Tea Cup', 'A flutter of birds soar across our fine bone china English Breakfast Cup and Saucer. A vintage-inspired set designed with the quintessential afternoon tea in mind.', 'assets/images/whittard-chelsea-garden-1.jpeg', 'assets/images/whittard-chelsea-garden-2.jpeg', '16.00', '<dl>\r\n<dt>Dimensions</dt>\r\n<dd>6cm(H) x 10.5cm(W) x 4.5cm(D)</dd>\r\n<dt>volume</dt>\r\n<dd>100ml</dd>\r\n<dt>feature</dt>\r\n<dd>We’ve brought quite the teacup collection to our beautiful Tea Discoveries range with dainty fine bone china cups and saucers to complement the delightful Tea Discoveries blends. Inspired by vintage patterns with a nod to afternoon tea’s celebrated heritage, this is a pairing to be treasured.\r\n</dd>\r\n</dl>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop_options`
--

CREATE TABLE `shop_options` (
  `option_id` int(11) NOT NULL,
  `option_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shop_options`
--

INSERT INTO `shop_options` (`option_id`, `option_name`) VALUES
(1, 'teema mug'),
(2, 'wonderlust');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` char(40) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `reg_date`) VALUES
(2, 'Emilie', 'Shin', 'emilie@shop.com', '9bc34549d565d9505b287de0cd20ac77be1d3f2c', '2021-03-23 22:01:34'),
(20, 'Anne', 'Smith', 'anne.smith@example.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2021-03-25 12:03:09'),
(25, 'Andy', 'Smith', 'a.smith@example.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2021-04-09 21:58:49'),
(24, 'Julie', 'Andrews', 'julie.andrews@example.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2021-04-09 21:43:56'),
(23, 'Justin', 'Bieber', 'j.bieber@example.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2021-03-25 12:15:01'),
(26, 'Alex', 'Johnsons', 'a.johnsons@example.com', 'c9948dbbfc78f00c38487a737c0c232c014a2dad', '2021-04-10 20:19:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discussion_likes`
--
ALTER TABLE `discussion_likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `forum_images`
--
ALTER TABLE `forum_images`
  ADD PRIMARY KEY (`fi_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_contents`
--
ALTER TABLE `order_contents`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `product_rates`
--
ALTER TABLE `product_rates`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `shop_options`
--
ALTER TABLE `shop_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussion_likes`
--
ALTER TABLE `discussion_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `forum_images`
--
ALTER TABLE `forum_images`
  MODIFY `fi_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_contents`
--
ALTER TABLE `order_contents`
  MODIFY `content_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_rates`
--
ALTER TABLE `product_rates`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `shop_options`
--
ALTER TABLE `shop_options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
