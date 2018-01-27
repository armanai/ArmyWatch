-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(62) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `admins` (`id`, `username`, `hashed_password`) VALUES
(1,   'armana',   '$2y$10$ZWE1Zjc5MTEzMDI5NmM1OONn0P9mQDPpnTGxbLdZ7zoygz9OZqiFO');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `sale` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `products` (`id`, `product_name`, `description`, `price`, `quantity`, `image`, `sale`) VALUES
(109, 'Shinola , Men\'s watch',  'The watch that helped launch Shinola as one of America&amp;rsquo;s most promising new lifestyle brands in 2011 looks as stylish and handsome five years later. If you&amp;rsquo;re in the market for a wear-everywhere (and with every outfit) type of timepiece, then this is the one for you. It&amp;rsquo;s well-designed without coming across as too precious and feels built-to-last from the first time you strap it on.',  134,  5, 'Shinola.jpg', 100),
(110, 'Fossil, Men\'s watch', 'A smartwatch that (actually) looks the part. With a new full-round digital display, our Q Venture offers multiple features like customizable faces, discreet notifications and automatic activity tracking to help make your life easier&mdash;and a bit more stylish.',  159.99,  8, 'fossil.jpg',  0),
(111, 'Gant, Men\'s watch',   'GANT men\'s watches offer a range of elegant choices for every occasion. The timepieces are versatile with European sophistication and classic round features, which intermesh with a contemporary design while staying true to the GANT American heritage of high quality materials and rich colours &ndash; a refined flair, making your look casual yet elegant. All watches come with a 2 year international warranty.', 45,   3, 'Gant.jpg', 0),
(112, 'Timex, Women\'s watch',   'Timex is an iconic American heritage watch brand renowned for its timeless designs. Founded in 1854, Timex has established a tradition of creating high-quality, innovative watches to suit the needs of every customer. Timex&reg; watches have been a part of consumers&rsquo; lives for over 160 years, and today combine high-end Italian designs with cutting edge German engineering to offer customers quality products. With a large and varied line of watches, Timex has a style for everyone.', 199.99,  2, 'Timex.jpg',   0),
(113, 'Mvmth, Men\'s watch',  'Every MVMT Watch we build has been carefully constructed with high-quality components, a minimalist design style in mind, and offered at the fairest price possible.  With so many great options available, it can be hard to choose the perfect model for you, but no worries - we\'ve rounded up our 4 most popular men\'s styles.',   300,  4, 'Mvmth.jpg',   0),
(114, 'Mvmth Classic Black Tan, Men\'s watch',  'Every MVMT Watch we build has been carefully constructed with high-quality components, a minimalist design style in mind, and offered at the fairest price possible.  With so many great options available, it can be hard to choose the perfect model for you, but no worries - we\'ve rounded up our 4 most popular men\'s styles.',   500,  4, 'Mvmth_classic.jpg', 0),
(115, 'Mvmth Boulevard, Women\'s watch',  'Every MVMT Watch we build has been carefully constructed with high-quality components, a minimalist design style in mind, and offered at the fairest price possible.  With so many great options available, it can be hard to choose the perfect model for you, but no worries - we\'ve rounded up our 4 most popular men\'s styles.',   249.99,  7, 'Mvmth_boulevard.jpg',  0),
(116, 'Larson and Jennings, Women\'s watch', 'The clean lines of our signature Lugano 40mm watch face combine with a black Italian leather strap, creating a subtle and sophisticated piece to celebrating dress watch aesthetic.', 189,  6, 'Larsson_and_jennings.jpg',   0),
(117, 'Panda, Women\'s watch',   'Womens Panda Dial Black Strap Watch found on Polyvore featuring jewelry, watches, quartz wrist watch, panda bear jewelry, buckle jewelry, dial watches and panda jewelry',   69,   15,   'Panda.jpg',   0),
(118, 'Omega, Women\'s watch',   'The OMEGA Olympic Pocket Watch 1932 Rattrapante Chronographs in 18K yellow, white or red gold are powered by rediscovered unassembled movement kits that had been in storage at OMEGA&rsquo;s headquarters in Biel since 1932. These horological wonders bring one of the brand&rsquo;s most storied products &ndash; the 1932 pocket chronograph &ndash; back to life.', 159.99,  5, 'Omega.jpg',   0),
(119, 'Flowers, Women\'s watch', 'Cherry Blossoms Floral Watch, Vintage Style Leather Watch, Women Watches, Boyfriend Watch, Genuine Leather by FreeForme on Etsy',  89.99,   20,   'Flowers.jpg', 0),
(120, 'Citizen, Men\'s watch',   'Citizen Watch Company steadfastly maintains quality craftsmanship and worldly style. In 1995, a major breakthrough was the light-powered watch. Any light source will power this watch, and stores up to six months of accurate time even in darkness. The Eco-Drive watch was born in the name of wasting less batteries and giving accessibility to beautiful watches to all citizens of the world.', 33.99,   17,   'Citizen.jpg', 0),
(121, 'Rolex, Men\'s watch',  'The Rolex Yacht-Master and Yacht-Master II models embody the spirit of the sailor. Inspired by the rich heritage that has bound Rolex to the world of sailing since the 1950s, the Yacht-Master blends function and style, while the Yacht-Master II brings together the finest in Rolex technology to create a regatta chronograph built for yachting competition.',  1599.99, 3, 'Rolex.jpg',   0),
(122, 'Co-Axial, Men\'s watch',  'An innovative new member of the Speedmaster family salutes its ancestor with some subtle aesthetic nods to the very first Speedmaster from 1957 combined with OMEGA\'s bold Co-Axial technology.',   299.99,  10,   'Omega_co_axial.jpg',   0),
(123, 'Cartier, Women\'s watch', '18 karat yellow gold, Rose gold, and White gold Cartier watch with Diamond bezel around the face.',  67,   19,   'Cartier.jpg', 0),
(124, 'Harry Winston, Women\'s watch', 'Harry Winston Rose Gold Midnight 39MM Women\'s Watch. This watch is made with a 18K rose gold case. The bezel is pave set with diamonds. The case is 39MM and the movement is quartz.',  100,  9, 'Harry_winston.jpg', 0),
(125, 'Skagen, Women\'s watch',  'Skagen Women\'s SKW2497 \'Anita\' Crystal Blue Leather Watch',   30,   5, 'Skagen.jpg',  0),
(126, 'Cluse, Women\'s watch',   'This attractive ladies Cluse Minuit Silver watch has a stainless steel case and is fitted with a quartz movement. It is fitted with a blue leather strap and has a white dial.',   30,   6, 'Cluse.jpg',   0),
(127, 'Vince Camuto, Women\'s watch',  'Brand: Vince Camuto Model #: VC/5315RGTT Case Material: Rose Gold-Tone Stainless Steel Case Thickness: 9mm Case Width: 40mm Bezel: Rose Gold-Tone Movement: Japanese Quartz Crystal: Mineral Dial: Light Rose Gold-Tone Textured', 93,   6, 'Vince_camuto.jpg',  70),
(128, 'Burberry, Women\'s watch',   'Burberry Large Check Stamped Bracelet Watch | $595 | gifts for her | womens watch | womens style | womens fashion | womenswear | love | wanteringa http://www.wantering.com/clothing-item/burberry-large-check-stamped-bracelet-watch/acGIC/', 67,   6, 'Burberry.jpg',   60),
(129, 'Egg, Women\'s watch',  'Our sophisticated pendant watch is based on an original gold and enamel miniature Faberg&eacute; egg (1896&ndash;1903) in the collection of the Virginia Museum of Fine Arts. The ultimate achievement of the House of Faberg&eacute; is the series of jeweled Easter eggs created for Czars Alexander III and Nicholas II of Russia. These delicate &quot;works of fantasy&quot; often memorialized important occasions in the reign of the Imperial Romanov family.',   58,   12,   'Egg.jpg',  40);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 2017-10-10 14:37:55