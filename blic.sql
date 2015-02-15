-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 15, 2015 at 06:10 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blic`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `comments_hier`(IN `p_comment_id` INT UNSIGNED)
begin

declare v_done tinyint unsigned default 0;
declare v_depth smallint unsigned default 0;

create temporary table hier(
 parent_comment_id smallint unsigned, 
 comment_id smallint unsigned, 
 depth smallint unsigned default 0
)engine = memory;

insert into hier select parent_comment_id, comment_id, v_depth from comments where comment_id = p_comment_id;

/* http://dev.mysql.com/doc/refman/5.0/en/temporary-table-problems.html */

create temporary table tmp engine=memory select * from hier;

while not v_done do

  if exists( select 1 from comments c inner join hier on c.parent_comment_id = hier.comment_id and hier.depth = v_depth) then

    insert into hier 
      select c.parent_comment_id, c.comment_id, v_depth + 1 from comments c
      inner join tmp on c.parent_comment_id = tmp.comment_id and tmp.depth = v_depth;

    set v_depth = v_depth + 1;      

    truncate table tmp;
    insert into tmp select * from hier where depth = v_depth;

  else
    set v_done = 1;
  end if;

end while;

select 
 c.comment_id ,
 c.subject ,  
 c.comm_text ,  
 c.comm_author_name ,  
 c.com_like ,  
 c.dislike ,  
 c.dtime , 
 p.comment_id as parent_comment_id,
 p.subject as parent_subject,
 hier.depth
from 
 hier
inner join comments c on hier.comment_id = c.comment_id
left outer join comments p on hier.parent_comment_id = p.comment_id
where c.is_view = 1
order by
 c.subject ,hier.depth, hier.comment_id;
drop temporary table if exists hier;
drop temporary table if exists tmp;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `comm_text` text NOT NULL,
  `comm_author_name` varchar(50) NOT NULL,
  `is_view` tinyint(4) NOT NULL,
  `del_num` int(11) NOT NULL,
  `com_like` int(11) NOT NULL,
  `dislike` int(11) NOT NULL,
  `dtime` datetime NOT NULL,
  `parent_comment_id` int(10) unsigned DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `parent_comment_id` (`parent_comment_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `subject`, `comm_text`, `comm_author_name`, `is_view`, `del_num`, `com_like`, `dislike`, `dtime`, `parent_comment_id`, `post_id`) VALUES
(20, '1', 'ovo je prvi komentar', 'Prvi', 1, 3, 68, 12, '2015-02-13 14:32:10', 0, 2),
(21, '1-1', 'ovo je dogovor na prvi', 'Odgovor na prvi', 1, 3, 17, 24, '2015-02-13 14:32:46', 20, 2),
(22, '1', 'teaggte', 'Test', 1, 1, 1, 0, '2015-02-13 14:39:27', 0, 3),
(23, '1-1-1', 'ovo je novi komentar', 'Novi Komenatr', 1, 2, 9, 8, '2015-02-14 13:02:19', 21, 2),
(24, '1', 'test komentar', 'Prvi kometar ', 1, 11, 9, 1, '2015-02-14 13:48:04', 0, 1),
(25, '1-1', 'ovo je novi komentar', 'armin', 1, 1, 4, 1, '2015-02-14 14:24:35', 24, 1),
(26, '2', 'ovo je novi komentar', 'Novi Komentar', 1, 0, 1, 0, '2015-02-14 16:45:02', 0, 1),
(27, '3', 'ovo je komentar 3', 'komentar 3', 1, 0, 0, 0, '2015-02-14 16:56:06', 0, 1),
(28, '1-2', 'kometars', 'komentar 3', 2, 0, 0, 0, '2015-02-14 21:06:01', 20, 2),
(29, '1-1-2', 'Bruka sta se radi kralju', 'Novi kom', 1, 1, 1, 0, '2015-02-14 21:52:40', 21, 2),
(30, '1-1-2', 'Ovo je komentar novi ', 'Odgovor na prvi u nizu', 1, 0, 0, 0, '2015-02-15 18:08:54', 21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `short_text` varchar(150) NOT NULL,
  `long_text` text NOT NULL,
  `author` varchar(30) NOT NULL,
  `datetime` datetime NOT NULL,
  `tags` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `short_text`, `long_text`, `author`, `datetime`, `tags`) VALUES
(1, 'Samsung predstavio novi model', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,', 'Drugi Autor', '2015-02-10 13:17:27', 'telefoni, samsung, prodaja, android'),
(2, 'iPhone prodaja (VIDEO)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget. Pellentesque tell', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,', 'Armin Kardovic', '2015-02-10 03:17:27', 'armin, post, novi'),
(3, 'Ko vas prati na fejsbuku', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet ri', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tellus sit amet risus varius luctus. Cras id ipsum eget nunc scelerisque sollicitudin quis sit amet erat. Sed placerat turpis odio, sed consectetur sapien consectetur vitae. Aliquam vel ultricies est. Quisque tempor risus lobortis, condimentum est dignissim, eleifend dui. Donec lobortis volutpat magna, gravida sagittis risus aliquet a. Pellentesque tellus tortor, auctor quis mattis eget, venenatis sed massa. Ut varius velit aliquam porta aliquam. Praesent dapibus iaculis risus, id ullamcorper ex cursus eu. Aliquam libero augue, fringilla at lacus eget, hendrerit gravida nisi. Fusce eget nisl odio. Nulla eu porta purus. Vestibulum vestibulum metus eget pulvinar tincidunt. Morbi bibendum, ipsum sagittis feugiat lobortis, orci metus tempus felis, nec sagittis ligula ex at erat. Aliquam dui metus, mollis sed eros id, ullamcorper fermentum nibh. Morbi rutrum quam sit amet urna dapibus, at bibendum est cursus. Maecenas arcu erat,', 'Armin Kardovic', '2015-02-08 03:11:38', 'facebook, dodaci, nova, opcija');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
