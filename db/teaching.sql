-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2013 at 04:03 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teaching`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `DueDate` date NOT NULL,
  `Description` varchar(1000) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`ID`, `CourseID`, `Title`, `DueDate`, `Description`) VALUES
(1, 1, 'Assignment 1', '2013-02-11', 'urna orci, volutpat nec pretium vitae, tincidunt ut arcu. In vestibulum nulla sit amet libero vulputate egestas.'),
(2, 1, 'Assignment 2', '2013-02-26', 'Aenean nulla dolor, ornare ac eleifend vel, varius ac tortor. Quisque placerat auctor justo, eu dignissim elit sagittis vel.'),
(3, 1, 'Assignment 3', '2013-02-27', 'Maecenas consequat rhoncus velit, nec congue arcu vehicula vel. Vestibulum vel tellus elit, et sagittis neque.'),
(4, 1, 'Assignment 4', '2013-03-28', 'Ut commodo ante at sem congue condimentum. Sed sed est turpis. Sed ut tortor neque. Morbi id metus sed dui iaculis volutpat gravida blandit elit.');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TeacherID` int(11) NOT NULL,
  `Number` varchar(20) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Syllabus` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `TeacherID` (`TeacherID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `TeacherID`, `Number`, `Title`, `Description`, `Syllabus`) VALUES
(1, 1, 'CS292', 'Special Topics on Web Development', 'HTML, CSS, JavaScript, PHP, MySQL', 'Nam orci mi, cursus id facilisis sit amet, viverra vitae leo. Vestibulum fermentum condimentum enim, in feugiat nibh luctus et.        Curabitur sem nibh, sodales vitae ultrices non, facilisis et turpis. Nunc blandit nunc nec mauris ultricies consectetur. Aliquam ac dui nisi.        Quisque pellentesque neque venenatis purus elementum vel mattis quam rhoncus. Duis tincidunt placerat erat non cursus. '),
(2, 2, 'OS101', 'Open Source Development', 'GPL, Freeware, copyleft, Linux, Git, agile method', 'In eu mauris id nulla euismod blandit.        Sed gravida sodales ligula, sed pharetra massa elementum vitae. Sed vitae diam est. Maecenas orci mi, aliquet vulputate laoreet non, interdum non lorem.        Vestibulum ligula quam, tincidunt eu tincidunt non, malesuada vitae velit. Pellentesque eu urna velit, eu viverra sapien. Duis tristique vestibulum vulputate.       Nulla facilisi. Vivamus urna quam, hendrerit quis semper in, sollicitudin sit amet justo.');

-- --------------------------------------------------------

--
-- Table structure for table `lecturenotes`
--

CREATE TABLE IF NOT EXISTS `lecturenotes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseID` int(11) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Content` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `lecturenotes`
--

INSERT INTO `lecturenotes` (`ID`, `CourseID`, `Title`, `Content`) VALUES
(1, 1, 'Introduction to HTML', 'Lorem ipsum dolor sit amet'),
(2, 1, 'Introduction to Webpage Styling', 'consectetur adipiscing elit'),
(3, 1, 'Some Basic CSS Techniques', 'Etiam et nisi eu elit elementum vestibulum sit amet vitae urna'),
(4, 1, 'Introduction to JavaScript', ' Quisque sapien leo'),
(5, 1, 'Programming with jQuery and its Plugins', 'mollis vitae pellentesque sit amet'),
(6, 1, 'Introduction to PHP and MySQL', 'semper sit amet nulla'),
(7, 1, 'Introduction to AJAX', 'Quisque ornare nisi magna');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LastName` varchar(20) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `YearEnrolled` year(4) NOT NULL,
  `ThumbnailURL` varchar(500) NOT NULL,
  `PortraitURL` varchar(500) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `ActivationKey` varchar(40) NOT NULL,
  `Verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `LastName`, `FirstName`, `Email`, `YearEnrolled`, `ThumbnailURL`, `PortraitURL`, `Password`, `ActivationKey`, `Verified`) VALUES
(1, 'Mouse', 'Mickey', 'MICKEY@ANONYMOUS.ORG', 2013, 'thumbnails/student1.jpg', 'images/student1.jpg', '0d538a366b3a3226d2e8996b62d4049f1faa7bb2', 'ff22c43ce0b5b95613f7ba2cad9852e2baef7b89', 1),
(2, 'Duck', 'Donald', 'DONALD@ANONYMOUS.ORG', 2013, 'thumbnails/student2.jpg', 'images/student2.gif', 'a269123cc5ad26812ccfe74aaafc5bcf5fbf9a0c', 'b23c27b6920da4085cefbf48f208870c8f67e1c6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `study`
--

CREATE TABLE IF NOT EXISTS `study` (
  `StudentID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  PRIMARY KEY (`StudentID`,`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `study`
--

INSERT INTO `study` (`StudentID`, `CourseID`) VALUES
(1, 1),
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `Office` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `ThumbnailURL` varchar(500) DEFAULT NULL,
  `PortraitURL` varchar(500) NOT NULL,
  `Password` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`ID`, `FirstName`, `LastName`, `Office`, `Email`, `ThumbnailURL`, `PortraitURL`, `Password`) VALUES
(1, 'Yi', 'Cui', 'FGH 379, 400 24th Ave S, Nashville, TN 37212', 'yicui2004@gmail.com', 'https://secure.gravatar.com/avatar/d0907d511f4560ebea7eee262068226b?s=200', 'https://secure.gravatar.com/avatar/d0907d511f4560ebea7eee262068226b?s=400', '59b95054cc5f395d27dc32407b1f9e6c2eee8828'),
(2, 'Mr', 'Anonymous', 'Magic Kingdom, Orlando, FL', 'anonymous@anonymous.org', 'http://www.gravatar.com/avatar?s=200', 'http://www.gravatar.com/avatar?s=400', '3371971f750b1effe1596cfb2f57d16ae64f1da1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `Course_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `teachers` (`ID`);

--
-- Constraints for table `lecturenotes`
--
ALTER TABLE `lecturenotes`
  ADD CONSTRAINT `lecturenotes_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`ID`) ON DELETE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
