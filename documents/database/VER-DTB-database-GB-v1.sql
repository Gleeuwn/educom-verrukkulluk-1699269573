-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 nov 2023 om 15:08
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkullukdatabase`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(5) NOT NULL,
  `naam` text NOT NULL,
  `omschrijving` text NOT NULL,
  `prijs` decimal(5,2) NOT NULL,
  `eenheid` text NOT NULL,
  `verpakking` varchar(255) NOT NULL,
  `calorie` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`id`, `naam`, `omschrijving`, `prijs`, `eenheid`, `verpakking`, `calorie`) VALUES
(1, 'vegan burger bun', 'Dit is een vegan broodje.', 2.00, 'broodje', 'zak broodjes à 4 stuks', 100),
(2, 'vegan burger', 'Dit is een vegan burger. Het bevat geen vleesproducten. Enkel vleesvervangers.', 3.00, 'gram', '2 burgers à 320 gram', 150),
(3, 'vegan burger sauce', 'Deze saus is helemaal vegan. Erg lekker.', 4.00, 'ml', 'fles à 500ml', 500),
(4, 'avocado', 'Een rijpe avocado, zonder pit.', 1.00, 'stuks', '4 stuks', 50);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht`
--

CREATE TABLE `gerecht` (
  `id` int(5) NOT NULL,
  `keuken_id` int(5) NOT NULL,
  `type_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `datum_toegevoegd` date NOT NULL,
  `titel` text NOT NULL,
  `korte_omschrijving` text NOT NULL,
  `lange_omschrijving` text NOT NULL,
  `afbeelding` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht`
--

INSERT INTO `gerecht` (`id`, `keuken_id`, `type_id`, `user_id`, `datum_toegevoegd`, `titel`, `korte_omschrijving`, `lange_omschrijving`, `afbeelding`) VALUES
(1, 1, 2, 1, '2023-11-07', 'Vegan Hamburger', 'Dit is een recept voor vegan hamburger.', 'Dit is een recept voor vegan hamburger. alle ingredienten zijn vegan. dit recept is gemaakt door Glenn.', ''),
(2, 3, 6, 1, '2023-11-07', 'Spaghetti', 'Dit is italiaanse spaghetti', 'dit is een langere omschrijving van de italiaanse spaghetti. heerlijk.', ''),
(3, 4, 5, 1, '2023-11-07', 'Sushi', 'Japanse sushi', 'Dit is een langere omschrijving over de sushi.', ''),
(4, 7, 8, 1, '2023-11-07', 'Boerenkool met worst', 'Dit is een recept voor boerenkool met worst', 'Dit is een langere omschrijving van boerenkool met worst.', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_info`
--

CREATE TABLE `gerecht_info` (
  `id` int(5) NOT NULL,
  `record_type` text NOT NULL,
  `gerecht_id` int(5) NOT NULL,
  `user_id` int(5) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `nummeriekveld` int(255) DEFAULT NULL,
  `tekstveld` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht_info`
--

INSERT INTO `gerecht_info` (`id`, `record_type`, `gerecht_id`, `user_id`, `datum`, `nummeriekveld`, `tekstveld`) VALUES
(1, 'O', 1, 1, '2023-11-07', 0, 'erg lekker.'),
(2, 'B', 1, NULL, NULL, 1, 'Snij het broodje en verwijder de pit van de avocado'),
(3, 'B', 1, NULL, NULL, 2, 'Bak de burger 5 minuten in de koekenpan.'),
(4, 'B', 1, NULL, NULL, 3, 'Doe de burger op het broodje. Smeer de avocado op de burger. Doe wat vegan sauce aan de binnekant van het broodje.'),
(7, 'B', 1, NULL, NULL, 4, 'Smullen maar!'),
(8, 'W', 1, NULL, NULL, 3, NULL),
(9, 'F', 1, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(5) NOT NULL,
  `gerecht_id` int(5) NOT NULL,
  `artikel_id` int(5) NOT NULL,
  `aantal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`id`, `gerecht_id`, `artikel_id`, `aantal`) VALUES
(1, 1, 1, '1'),
(2, 1, 2, '2'),
(3, 1, 3, '30'),
(4, 1, 4, '1');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `keuken_type`
--

CREATE TABLE `keuken_type` (
  `id` int(5) NOT NULL,
  `record_type` text NOT NULL,
  `omschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `keuken_type`
--

INSERT INTO `keuken_type` (`id`, `record_type`, `omschrijving`) VALUES
(1, 'K', 'Amerikaans'),
(2, 'T', 'Vegan'),
(3, 'K', 'Italiaans'),
(4, 'K', 'Japans'),
(5, 'T', 'Vis'),
(6, 'T', 'Pasta'),
(7, 'K', 'Nederlands'),
(8, 'T', 'Stampot');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `afbeelding` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `afbeelding`) VALUES
(1, 'Glenn', 'glenn123', 'glenn@glenn.nl', ''),
(2, 'henk', 'henk123', 'henk@henk.nl', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `keuken_id` (`keuken_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `gerecht_id` (`gerecht_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `gerecht_id` (`gerecht_id`);

--
-- Indexen voor tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `gerecht`
--
ALTER TABLE `gerecht`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD CONSTRAINT `gerecht_ibfk_1` FOREIGN KEY (`keuken_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `gerecht_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `gerecht_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD CONSTRAINT `gerecht_info_ibfk_1` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`id`),
  ADD CONSTRAINT `gerecht_info_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `ingredient_ibfk_2` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
