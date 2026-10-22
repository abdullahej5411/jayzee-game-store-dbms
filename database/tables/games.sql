-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 12:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamestoredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `GameID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `ReleaseDate` date DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Stock` int(11) DEFAULT 0,
  `PublisherID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `TrailerURL` varchar(255) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`GameID`, `Title`, `Description`, `ReleaseDate`, `Price`, `Stock`, `PublisherID`, `CategoryID`, `TrailerURL`, `ImageURL`) VALUES
(4, 'Cyberpunk 2077', 'Cyberpunk 2077 is an open-world RPG set in the dystopian Night City. Players assume the role of V, a customizable mercenary navigating a neon-lit world of crime and technology. Engage in intense combat, hacking, and exploration with deep narrative choices. The game blends futuristic aesthetics with immersive storytelling and dynamic gameplay.', '2020-12-10', 59.99, 50, 4, 1, 'https://youtu.be/UjxS9ciNlII?si=qIBxK5LcthUR9C56', 'assets/images/games/4.jpg'),
(5, 'Assassin\'s Creed Valhalla', 'Assassin\'s Creed Valhalla immerses players in the Viking Age as Eivor, a fierce warrior. Explore a vast open world of medieval England, raiding settlements and forging alliances. Master stealth, melee combat, and settlement-building in a richly detailed historical adventure. The game offers epic battles and deep narrative choices.', '2020-11-10', 49.99, 30, 2, 1, 'https://youtu.be/rKjUAWlbTJk?si=_URvD8Q8ddntwkt_', 'assets/images/games/5.jpg'),
(6, 'Call of Duty: Modern Warfare', 'Call of Duty: Modern Warfare delivers heart-pounding first-person shooter action. Experience a gripping single-player campaign and fast-paced multiplayer modes. Engage in tactical combat across global battlefields with cutting-edge weaponry. Its realistic visuals and intense gameplay redefine the iconic franchise.', '2019-10-25', 69.99, 75, 6, 11, 'https://youtu.be/bH1lHCirCGI?si=cKD8YL5IudtTtWxa', 'assets/images/games/6.jpg'),
(7, 'Grand Theft Auto V', 'Grand Theft Auto V offers a sprawling open-world adventure in Los Santos. Play as three distinct criminals navigating a web of heists, crime, and chaos. Explore a vibrant city, engage in action-packed missions, and enjoy robust online multiplayer. The game blends satire, storytelling, and endless replayability.', '2013-09-17', 39.99, 100, 7, 1, 'https://youtu.be/QkkoHAzjnUs?si=04K6jv4_fMpjMtfF', 'assets/images/games/7.jpg'),
(8, 'Resident Evil Village', 'Resident Evil Village is a chilling survival horror experience set in a gothic Eastern European village. Play as Ethan Winters, facing terrifying creatures and unraveling dark mysteries. Combine intense combat, exploration, and puzzle-solving in a haunting atmosphere. Its stunning visuals and gripping story captivate horror fans.', '2021-05-07', 59.99, 40, 8, 13, 'https://youtu.be/arEdruKxrQ8?si=7o4F6M0bEy8EnkiN', 'assets/images/games/8.jpg'),
(9, 'The Legend of Zelda: Breath of the Wild', 'The Legend of Zelda: Breath of the Wild redefines open-world adventures. Explore the vast kingdom of Hyrule as Link, mastering survival, combat, and puzzles. Discover shrines, craft items, and tackle dynamic weather and physics-based challenges. Its breathtaking landscapes and freedom of exploration are unparalleled.', '2017-03-03', 59.99, 100, 3, 2, 'https://youtu.be/zw47_q9wbBE?si=3jPBF3qTAldM6FRe', 'assets/images/games/9.jpg'),
(10, 'Final Fantasy XIV', 'Final Fantasy XIV is a vibrant MMORPG set in the fantasy realm of Eorzea. Create a unique character and embark on epic quests with players worldwide. Engage in strategic combat, crafting, and deep storytelling across expansive expansions. Its rich world and community make it a standout MMO.', '2013-08-27', 39.99, 20, 5, 4, 'https://youtu.be/4tyuIh12_HU?si=9VVF0ILno56z32qj', 'assets/images/games/10.jpg'),
(11, 'FIFA 23', 'FIFA 23 brings realistic football simulation to life with updated teams and mechanics. Play as global clubs or create your own career in dynamic modes. Experience enhanced gameplay with HyperMotion technology for authentic player movements. Multiplayer and Ultimate Team modes offer endless competitive fun.', '2022-09-30', 69.99, 80, 1, 5, 'https://youtu.be/o3V-GvvzjE4?si=f3w-BTKHKWohdbF3', 'assets/images/games/11.jpg'),
(12, 'Mario Kart 8 Deluxe', 'Mario Kart 8 Deluxe is a vibrant racing game featuring Mario and friends. Speed through colorful, gravity-defying tracks with strategic item-based combat. Enjoy local and online multiplayer for chaotic, family-friendly fun. Its polished mechanics and diverse courses ensure endless replayability.', '2017-04-28', 59.99, 90, 3, 6, 'https://youtu.be/tKlRN2YpxRE?si=TNSckd2wPvojhDZq', 'assets/images/games/12.jpg'),
(13, 'The Sims 4', 'The Sims 4 is a life simulation sandbox with boundless creativity. Build unique characters, design dream homes, and control every aspect of their lives. Explore relationships, careers, and personal goals in a dynamic world. Expansions and mods add infinite customization for players.', '2014-09-02', 49.99, 60, 1, 7, 'https://www.youtube.com/watch?v=GJENRAB4ykA', 'assets/images/games/13.jpg'),
(14, 'Tetris Effect', 'Tetris Effect transforms the classic puzzle game with mesmerizing visuals and music. Stack falling blocks in sync with immersive soundscapes across surreal stages. Experience innovative modes like Journey and multiplayer challenges. Its hypnotic presentation elevates a timeless formula.', '2018-11-09', 39.99, 50, 9, 8, 'https://www.youtube.com/watch?v=PFVL6t8IHE8', 'assets/images/games/14.jpg'),
(15, 'Super Mario Odyssey', 'Super Mario Odyssey is a whimsical 3D platformer starring Mario. Travel across diverse kingdoms with Cappy, a sentient hat, to rescue Princess Peach. Master creative platforming and exploration in vibrant, sandbox-style worlds. Its charming visuals and inventive mechanics delight players of all ages.', '2017-10-27', 59.99, 70, 3, 9, 'https://www.youtube.com/watch?v=5kcdRBHM7kM', 'assets/images/games/15.jpg'),
(16, 'Street Fighter V', 'Street Fighter V is a high-octane fighting game with iconic characters. Master precise combos and strategic combat in intense one-on-one battles. Compete in ranked online matches or enjoy a cinematic story mode. Its deep mechanics and vibrant visuals appeal to casual and competitive players.', '2016-02-16', 29.99, 30, 8, 10, 'https://www.youtube.com/watch?v=0nFd7Iylj5A', 'assets/images/games/16.jpg'),
(17, 'StarCraft II', 'StarCraft II is a landmark real-time strategy game set in a sci-fi universe. Command Terran, Zerg, or Protoss forces in tactical battles and resource management. Engage in a rich campaign or dominate in competitive multiplayer. Its depth and balance make it an esports staple.', '2010-07-27', 29.99, 40, 4, 3, 'https://www.youtube.com/watch?v=aVtXac6if14', 'assets/images/games/17.jpg'),
(18, 'Madden NFL 24', 'Madden NFL 24 delivers authentic American football simulation. Control NFL teams with updated rosters, mastering strategic play-calling and skill-based mechanics. Compete in Franchise mode or online multiplayer for intense gridiron action. Enhanced animations and physics elevate the sports experience.', '2023-08-18', 69.99, 70, 1, 5, 'https://www.youtube.com/watch?v=UVZ0IIeW2mw', 'assets/images/games/18.jpg'),
(19, 'Need for Speed Heat', 'Need for Speed Heat is an adrenaline-fueled arcade racer set in Palm City. Race by day to earn cash and by night to build your reputation. Customize high-performance cars and evade relentless cops in thrilling chases. Its dynamic day-night cycle adds strategic depth.', '2019-11-08', 59.99, 45, 1, 6, 'https://www.youtube.com/watch?v=9ewiJJe_nYI', 'assets/images/games/19.jpg'),
(20, 'Cities: Skylines', 'Cities: Skylines is a deep city-building simulator with intricate mechanics. Design and manage sprawling metropolises, balancing economy, traffic, and citizen needs. Customize with mods and tackle unique challenges like natural disasters. Its detailed systems reward creative urban planning.', '2015-03-10', 29.99, 35, 15, 7, 'https://www.youtube.com/watch?v=0gI2N10QyRA', 'assets/images/games/20.jpg'),
(21, 'Portal 2', 'Portal 2 is a mind-bending puzzle-platformer with innovative portal mechanics. Solve intricate test chambers using a portal gun in a darkly humorous sci-fi world. Enjoy solo or co-op campaigns with witty writing and clever puzzles. Its creative design remains a genre classic.', '2011-04-19', 19.99, 25, 7, 8, 'https://www.youtube.com/watch?v=A88YiZdXugA', 'assets/images/games/21.jpg'),
(22, 'Donkey Kong Country: Tropical Freeze', 'Donkey Kong Country: Tropical Freeze is a vibrant platformer with challenging levels. Play as Donkey Kong and friends, navigating tropical islands with tight controls. Tackle dynamic stages, collectibles, and epic boss fights. Its colorful art and co-op mode shine.', '2014-02-21', 49.99, 50, 3, 9, 'https://www.youtube.com/watch?v=1psp2t0Zi9o', 'assets/images/games/22.jpg'),
(23, 'Mortal Kombat 11', 'Mortal Kombat 11 is a brutal fighting game with visceral combat. Master a roster of iconic fighters in cinematic battles with gruesome fatalities. Enjoy a gripping story mode and competitive online play. Its polished mechanics and stunning visuals redefine the franchise.', '2019-04-23', 49.99, 40, 10, 10, 'https://www.youtube.com/watch?v=YUu77vYUoWo', 'assets/images/games/23.jpg'),
(24, 'Overwatch 2', 'Overwatch 2 is a team-based shooter with diverse heroes and roles. Compete in fast-paced, objective-driven matches across global arenas. Master unique abilities and strategic teamwork in vibrant multiplayer modes. Its evolving content keeps the action fresh and engaging.', '2022-10-04', 39.99, 60, 6, 11, 'https://www.youtube.com/watch?v=LGgqyer-qr4', 'assets/images/games/24.jpg'),
(25, 'The Last of Us Part I', 'The Last of Us Part I is a gripping survival action game with emotional depth. Follow Joel and Ellie through a post-apocalyptic world filled with infected and human threats. Experience stealth, combat, and heartfelt storytelling. Its remastered visuals enhance a modern classic.', '2022-09-02', 69.99, 30, 7, 12, 'https://www.youtube.com/watch?v=WxjeV10H1F0', 'assets/images/games/25.jpg'),
(26, 'Dead by Daylight', 'Dead by Daylight is an asymmetrical multiplayer horror game. Play as a survivor evading a relentless killer or hunt as the killer in tense matches. Master unique perks and strategies in eerie, randomized maps. Its cat-and-mouse gameplay delivers chilling thrills.', '2016-06-14', 29.99, 50, 18, 13, 'https://www.youtube.com/watch?v=JGhIXLO3ul8', 'assets/images/games/26.jpg'),
(27, 'Guitar Hero Live', 'Guitar Hero Live transforms rhythm gaming with a live-action crowd. Rock out on a guitar controller, mastering tracks across genres on a virtual stage. Experience dynamic performances and competitive multiplayer modes. Its immersive first-person perspective amplifies the rock star fantasy.', '2015-10-20', 39.99, 20, 11, 14, 'https://youtu.be/tJBCrTBT5g8?si=mjoN6GCSTWJ1w6qK', 'assets/images/games/27.jpg'),
(29, 'Red Dead Redemption 2', 'Red Dead Redemption 2 is an epic open-world Western adventure. Play as Arthur Morgan, an outlaw navigating a richly detailed American frontier. Engage in immersive storytelling, heists, and exploration with deep NPC interactions. Its breathtaking visuals and freedom redefine open-world gaming.', '2018-10-26', 59.99, 80, 7, 1, 'https://www.youtube.com/watch?v=eaW0tYpxyp0', 'assets/images/games/29.jpg'),
(30, 'Monster Hunter Rise', 'Monster Hunter Rise is an action RPG focused on cooperative hunting. Track and slay massive monsters in vibrant, vertical environments as a customizable hunter. Craft gear from loot and master diverse weapons in thrilling battles. Its fluid combat and multiplayer shine.', '2021-03-26', 59.99, 45, 10, 4, 'https://www.youtube.com/watch?v=TdCec2GRg-w', 'assets/images/games/30.jpg'),
(31, 'NBA 2K23', 'NBA 2K23 offers a premier basketball simulation with authentic gameplay. Control NBA stars or build a career in MyCareer mode with updated rosters. Enjoy refined mechanics, realistic visuals, and competitive online modes. Its depth caters to casual and hardcore fans alike.', '2022-09-09', 69.99, 65, 13, 5, 'https://www.youtube.com/watch?v=R1RMvl_Ag28', 'assets/images/games/31.jpg'),
(32, 'Forza Horizon 5', 'Forza Horizon 5 is an open-world racing masterpiece set in a vibrant Mexico. Drive exotic cars across deserts, jungles, and cities in dynamic weather. Compete in races, stunts, and multiplayer events with endless customization. Its stunning visuals and freedom exhilarate.', '2021-11-09', 59.99, 55, 12, 6, 'https://www.youtube.com/watch?v=FYH9n37B7Yw', 'assets/images/games/32.jpg'),
(33, 'Flight Simulator 2020', 'Flight Simulator 2020 delivers a hyper-realistic flight experience. Pilot aircraft across a detailed global map with real-time weather and traffic. Explore stunning landscapes and master complex flight mechanics. Its unparalleled authenticity appeals to aviation enthusiasts and newcomers.', '2020-08-18', 59.99, 30, 19, 7, 'https://www.youtube.com/watch?v=TYqJALPVn0Y', 'assets/images/games/33.jpg'),
(34, 'Candy Crush Saga', 'Candy Crush Saga is a wildly addictive match-three puzzle game. Swap colorful candies to clear levels with creative boosters and challenges. Enjoy thousands of levels with vibrant visuals and social features. Its simple yet deep gameplay hooks players worldwide.', '2012-04-12', 0.00, 1000, 14, 8, 'https://www.youtube.com/watch?v=Tk8GKRFiAmU', 'assets/images/games/34.jpg'),
(35, 'Sonic Mania', 'Sonic Mania is a nostalgic 2D platformer celebrating Sonic the Hedgehog. Dash through reimagined classic zones and new stages with retro pixel art. Play as Sonic, Tails, or Knuckles with tight controls. Its vibrant design and speed thrill fans old and new.', '2017-08-15', 19.99, 40, 9, 9, 'https://www.youtube.com/watch?v=VYQNnrccbj8', 'assets/images/games/35.jpg'),
(36, 'Tekken 7', 'Tekken 7 is a legendary fighting game with intense 3D combat. Master a diverse roster with deep move sets in cinematic battles. Enjoy a dramatic story mode and competitive online play. Its refined mechanics and visuals make it a genre standout.', '2015-03-18', 39.99, 35, 10, 10, 'https://www.youtube.com/watch?v=kKLCwDg2JLA', 'assets/images/games/36.jpg'),
(37, 'Destiny 2', 'Destiny 2 is a sci-fi shooter blending FPS and RPG elements. Explore vibrant planets as a Guardian, wielding powers and weapons in cooperative and competitive modes. Engage in raids, quests, and evolving storylines. Its dynamic world keeps players invested.', '2017-09-06', 39.99, 50, 6, 11, 'https://www.youtube.com/watch?v=hdWkpbPTpmE', 'assets/images/games/37.jpg'),
(38, 'Subnautica', 'Subnautica is a survival adventure set on an alien ocean planet. Dive into vibrant underwater biomes, crafting tools and bases to survive. Explore mysterious depths, uncover a gripping story, and manage resources. Its immersive exploration and beauty captivate players.', '2018-01-23', 29.99, 45, 15, 12, 'https://www.youtube.com/watch?v=Rz2SNm8VguE', 'assets/images/games/38.jpg'),
(39, 'Outlast', 'Outlast is a terrifying survival horror game with relentless tension. Play as a journalist trapped in a nightmarish asylum, evading deranged enemies. Rely on stealth and a camcorder’s night vision to survive. Its oppressive atmosphere delivers unforgettable scares.', '2013-09-04', 19.99, 30, 18, 13, 'https://www.youtube.com/watch?v=2GPf3MdVOKI', 'assets/images/games/39.jpg'),
(40, 'Rock Band 4', 'Rock Band 4 is a music rhythm game simulating a rock band experience. Jam with friends on guitar, drums, or vocals across iconic tracks. Build setlists and compete in multiplayer modes. Its authentic instruments and energetic vibe rock the party.', '2015-10-06', 59.99, 25, 11, 14, 'https://www.youtube.com/watch?v=uzLgoxJQXCE', 'assets/images/games/40.jpg'),
(41, 'Wii Sports', 'Wii Sports is a family-friendly sports party game with intuitive motion controls. Compete in tennis, baseball, bowling, golf, and boxing with simple yet addictive gameplay. Enjoy multiplayer fun with friends and family. Its accessibility and charm remain timeless.', '2006-11-19', 39.99, 60, 3, 15, 'https://www.youtube.com/watch?v=zqaPFAZS1K8', 'assets/images/games/41.jpg'),
(42, 'Watch Dogs 2', 'Watch Dogs 2 is an open-world action game set in a vibrant San Francisco. Play as hacker Marcus Holloway, using tech to disrupt a corrupt system. Engage in stealth, combat, and creative hacking in a dynamic sandbox. Its humor and freedom shine.', '2016-11-15', 49.99, 40, 2, 1, 'https://www.youtube.com/watch?v=y_IIVmc_Qi4', 'assets/images/games/42.jpg'),
(43, 'Dragon Quest XI', 'Dragon Quest XI is a classic turn-based RPG with a heartfelt story. Follow the Luminary on a quest through a colorful fantasy world. Master strategic combat and explore charming towns and dungeons. Its timeless design and rich narrative enchant players.', '2018-09-04', 59.99, 35, 5, 4, 'https://www.youtube.com/watch?v=bg0oBJ9cXYM', 'assets/images/games/43.jpg'),
(44, 'F1 2022', 'F1 2022 is a thrilling Formula 1 racing simulator with authentic tracks and teams. Master high-speed races and strategic pit stops in dynamic weather. Build your career in My Team mode or compete online. Its realism captivates racing fans.', '2022-06-30', 59.99, 50, 19, 6, 'https://youtu.be/Nx9NgXi8nP8?si=jtKKI-ZtA-KDfddm', 'assets/images/games/44.jpg'),
(45, 'Planet Zoo', 'Planet Zoo is a detailed zoo management simulator with stunning animals. Design habitats, manage animal welfare, and balance guest satisfaction. Explore a rich campaign or unleash creativity in sandbox mode. Its depth and visuals make every zoo a masterpiece.', '2019-11-05', 44.99, 30, 15, 7, 'https://youtu.be/TAvzq-HrSoQ?si=vzKeWlO5C_xchSio', 'assets/images/games/45.jpg'),
(46, 'The Witness', 'The Witness is a cerebral puzzle game set on a mysterious island. Solve intricate environmental puzzles woven into a vibrant, open world. Uncover philosophical themes and hidden secrets through exploration. Its minimalist design and clever challenges reward patient players.', '2016-01-26', 39.99, 20, 7, 8, 'https://youtu.be/ul7kNFD6noU?si=AX6ZSlUeyfYD0GxQ', 'assets/images/games/46.jpg'),
(47, 'Rayman Legends', 'Rayman Legends is a whimsical platformer with stunning hand-drawn art. Dash through imaginative worlds with precise controls and rhythmic levels. Enjoy co-op multiplayer and musical stages for endless fun. Its creativity and charm captivate players of all ages.', '2013-08-30', 29.99, 45, 9, 9, 'https://youtu.be/yMIKs1PKrEM?si=O8JlLzkH96qIDhQD', 'assets/images/games/47.jpg'),
(48, 'Soulcalibur VI', 'Soulcalibur VI is a weapon-based fighting game with cinematic flair. Master a diverse roster of warriors in fast-paced, strategic battles. Enjoy a rich story mode and robust character customization. Its polished combat and visuals elevate the genre.', '2018-10-19', 49.99, 30, 10, 10, 'https://youtu.be/OWf-VVY7N5g?si=rT8SoCWInBU27Csj', 'assets/images/games/48.jpg'),
(49, 'Apex Legends', 'Apex Legends is a fast-paced, free-to-play battle royale shooter. Team up as unique Legends with distinct abilities in dynamic, squad-based matches. Master fluid movement and tactical combat on evolving maps. Its polish and innovation keep players hooked.', '2019-02-04', 0.00, 100, 6, 11, 'https://youtu.be/oQtHENM_GZU?si=tlBLE3lF1qKhrvMM', 'assets/images/games/49.jpg'),
(50, 'Rust', 'Rust is a brutal multiplayer survival game in a harsh open world. Scavenge, build bases, and fight other players to survive. Form alliances or betray others in a tense, unforgiving sandbox. Its emergent gameplay and danger create unforgettable moments.', '2018-02-08', 39.99, 40, 18, 12, 'https://youtu.be/LGcECozNXEw?si=X93_S1cLNUoNnstk', 'assets/images/games/50.jpg'),
(51, 'Amnesia: The Dark Descent', 'Amnesia: The Dark Descent is a landmark psychological horror game. Explore a creepy castle as Daniel, solving puzzles while evading grotesque monsters. Manage sanity and light to survive an oppressive atmosphere. Its immersive dread influences modern horror gaming.', '2010-09-08', 19.99, 25, 15, 13, 'https://youtu.be/u1nY_5-UrY4?si=fjdnfYhqyz7gq1l6', 'assets/images/games/51.jpg'),
(52, 'Beat Saber', 'Beat Saber is an exhilarating VR rhythm game with lightsaber-like mechanics. Slice through beats in sync with energetic music in immersive 3D stages. Master precise swings across varied difficulty levels. Its addictive gameplay and fitness appeal make it a VR standout.', '2018-05-21', 29.99, 30, 14, 14, 'https://youtu.be/vL39Sg2AqWg?si=kU5cMSWSjYLitQYW', 'assets/images/games/52.jpg'),
(53, 'Mario Party Superstars', 'Mario Party Superstars is a festive party game with classic mini-games. Compete on nostalgic boards with Mario and friends in chaotic multiplayer. Enjoy strategic dice rolls and unpredictable events. Its polished fun and accessibility unite players for lively gatherings.', '2021-10-29', 59.99, 50, 3, 15, 'https://youtu.be/2jEq0F656aY?si=uIO68z5O2RMtNtUA', 'assets/images/games/53.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`GameID`),
  ADD KEY `idx_game_title` (`Title`),
  ADD KEY `PublisherID` (`PublisherID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `GameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`PublisherID`) REFERENCES `publishers` (`PublisherID`) ON DELETE SET NULL,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
