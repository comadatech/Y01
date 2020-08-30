-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2020 at 10:24 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `y01`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GetActivityDetail` (IN `ActivityScheduleID` INT, IN `language` CHAR(3))  BEGIN

/*set language from month name and day name*/
IF (language = "Fra") THEN
	SET lc_time_names = 'fr_FR';
else
	SET lc_time_names = 'en_US';
END IF;

select Activity.ActivityID
,if(language="Fra",activity.ActivityNameFra, activity.ActivityNameEng) as ActivityName
,if(language="Fra",activity.ActivityDescFra, activity.ActivityDescEng) as ActivityDesc
,Activity.ActivityTypeID
,if(language="Fra",Activitytype.ActivityTypeNameFra, Activitytype.ActivityTypeNameEng) as ActivityTypeName
,Activity.ActivityLevelID
,if(language="Fra",ActivityLevel.ActivityLevelNameFra, ActivityLevel.ActivityLevelNameEng) as ActivityLevelName
,activityschedule.LocationID
,if(language="Fra",location.LocationNameFra, location.LocationNameEng) as Location
,schedule.ScheduleID
,if(language="Fra",schedule.ScheduleNameFra, schedule.ScheduleDescEng) as ScheduleDesc
,schedule.ScheduleTypeID
,if(language="Fra",scheduletype.ScheduleTypeNameFra,scheduletype.ScheduleTypeNameEng) as ScheduleTypeName
,schedule.ScheduleDayID
,if(language="Fra",scheduleday.ScheduleDayNameFra,scheduleday.ScheduleDayNameEng) as ScheduleDayName
,schedule.StartDate
,schedule.EndDate
,schedule.StartTime
,schedule.EndTime
,if(language="Fra",
concat('<strong>',Activity.ActivityNameFra, '</strong> (', ActivityLevelNameFra ,')<br>&nbsp;&nbsp;&nbsp;Tous les '
,if(schedule.ScheduleTypeID = 1,'Jours'
,if(schedule.ScheduleTypeID = 2,scheduleday.ScheduleDayNameFra
,if(schedule.ScheduleTypeID = 3,'mois'
,if(schedule.ScheduleTypeID = 4,'ans',''))))
,' à ', StartTime , '<br>&nbsp;&nbsp;&nbsp;Commencant le ', UF_GetFormatDate(StartDate,'Fra') , '<br>&nbsp;&nbsp;&nbsp;Finissant le ' ,  UF_GetFormatDate(EndDate,'Fra'),'<br>&nbsp;&nbsp;&nbsp;Instructeur: ',concat('<a href="instructor.php?instructorid=',activityschedule.instructorid,'">',instructor.firstname,' ',instructor.Lastname,"</a>"))
,concat('<strong>',Activity.ActivityNameEng, '</strong> (', ActivityLevelNameEng ,')<br>&nbsp;&nbsp;&nbsp;Every '
,if(schedule.ScheduleTypeID = 1,'day'
,if(schedule.ScheduleTypeID = 2,scheduleday.ScheduleDayNameEng
,if(schedule.ScheduleTypeID = 3,'month'
,if(schedule.ScheduleTypeID = 4,'year',''))))
,' at ', StartTime , '<br>&nbsp;&nbsp;&nbsp;Starting on ', UF_GetFormatDate(StartDate,'Eng')  , '<br>&nbsp;&nbsp;&nbsp;Endding on ' , UF_GetFormatDate(EndDate,'Eng'),'<br>&nbsp;&nbsp;&nbsp;Instructor: ',concat('<a href="instructor.php?instructorid=',activityschedule.instructorid,'">',instructor.firstname,' ',instructor.Lastname,"</a>"))
) as ScheduleDescription
,if(schedule.startdate < now(),'Y','N') as AlreadyStarted
,activityschedule.ActivityPrice 
,activityschedule.activityscheduleid
,activity.image
from activity
	join activityschedule
	on activity.ActivityID = activityschedule.ActivityID

	    	join location
    		on activityschedule.LocationID = location.LocationID
    
		join schedule
        	on activityschedule.ScheduleID = schedule.ScheduleID

		join person as instructor
		on activityschedule.instructorid = instructor.personid
        
			join scheduletype
            on schedule.ScheduleTypeID = scheduletype.ScheduleTypeID
            
            join scheduleday
            on schedule.ScheduleDayID = scheduleday.ScheduleDayID
    
    join ActivityType
    on Activity.ActivityTypeID = ActivityType.ActivityTypeID
    
    join ActivityLevel
    on activity.ActivityLevelID = ActivityLevel.ActivityLevelID

where Activity.activeind = 'Y'
and activityschedule.activityscheduleid = ActivityScheduleID 
and (Activity.DeactivatedDate is null or Activity.DeactivatedDate = 0)
and Activityschedule.activeind = 'Y'
and (Activityschedule.DeactivatedDate is null or Activityschedule.DeactivatedDate = 0)
and ActivityType.activeind = 'Y'
and (ActivityType.DeactivatedDate is null or ActivityType.DeactivatedDate = 0)
and ActivityLevel.activeind = 'Y'
and (ActivityLevel.DeactivatedDate is null or ActivityLevel.DeactivatedDate = 0)
and Location.activeind = 'Y'
and (Location.DeactivatedDate is null or Location.DeactivatedDate = 0)
and schedule.ActiveIND = 'Y'
and (schedule.DeactivatedDate is null or schedule.DeactivatedDate = 0)
and scheduletype.ActiveIND = 'Y'
and (scheduletype.DeactivatedDate is null or scheduletype.DeactivatedDate = 0)
and scheduleday.ActiveIND = 'Y'
and (scheduleday.DeactivatedDate is null or scheduleday.DeactivatedDate = 0)
and schedule.enddate > now();

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GetActivityScheduleDetail` (IN `ActivityScheduleID` INT, IN `language` CHAR(3))  BEGIN

/*set language from month name and day name*/
IF (language = "Fra") THEN
	SET lc_time_names = 'fr_FR';
else
	SET lc_time_names = 'en_US';
END IF;

select Activity.ActivityID
,if(language="Fra",activity.ActivityNameFra, activity.ActivityNameEng) as ActivityName
,if(language="Fra",activity.ActivityDescFra, activity.ActivityDescEng) as ActivityDesc
,Activity.ActivityTypeID
,if(language="Fra",Activitytype.ActivityTypeNameFra, Activitytype.ActivityTypeNameEng) as ActivityTypeName
,Activity.ActivityLevelID
,if(language="Fra",ActivityLevel.ActivityLevelNameFra, ActivityLevel.ActivityLevelNameEng) as ActivityLevelName
,activityschedule.LocationID
,if(language="Fra",location.LocationNameFra, location.LocationNameEng) as Location
,schedule.ScheduleID
,if(language="Fra",schedule.ScheduleNameFra, schedule.ScheduleDescEng) as ScheduleDesc
,schedule.ScheduleTypeID
,if(language="Fra",scheduletype.ScheduleTypeNameFra,scheduletype.ScheduleTypeNameEng) as ScheduleTypeName
,schedule.ScheduleDayID
,if(language="Fra",scheduleday.ScheduleDayNameFra,scheduleday.ScheduleDayNameEng) as ScheduleDayName
,schedule.StartDate
,schedule.EndDate
,schedule.StartTime
,schedule.EndTime
,if(language="Fra",
concat('<strong>',Activity.ActivityNameFra, '</strong> (', ActivityLevelNameFra ,')<br>&nbsp;&nbsp;&nbsp;Tous les '
,if(schedule.ScheduleTypeID = 1,'Jours'
,if(schedule.ScheduleTypeID = 2,scheduleday.ScheduleDayNameFra
,if(schedule.ScheduleTypeID = 3,'mois'
,if(schedule.ScheduleTypeID = 4,'ans',''))))
,' à ', StartTime , '<br>&nbsp;&nbsp;&nbsp;Commencant le ', UF_GetFormatDate(StartDate,'Fra') , '<br>&nbsp;&nbsp;&nbsp;Finissant le ' ,  UF_GetFormatDate(EndDate,'Fra'),'<br>&nbsp;&nbsp;&nbsp;Instructeur: ',concat('<a href="instructor.php?instructorid=',activityschedule.instructorid,'">',instructor.firstname,' ',instructor.Lastname,"</a>"))
,concat('<strong>',Activity.ActivityNameEng, '</strong> (', ActivityLevelNameEng ,')<br>&nbsp;&nbsp;&nbsp;Every '
,if(schedule.ScheduleTypeID = 1,'day'
,if(schedule.ScheduleTypeID = 2,scheduleday.ScheduleDayNameEng
,if(schedule.ScheduleTypeID = 3,'month'
,if(schedule.ScheduleTypeID = 4,'year',''))))
,' at ', StartTime , '<br>&nbsp;&nbsp;&nbsp;Starting on ', UF_GetFormatDate(StartDate,'Eng')  , '<br>&nbsp;&nbsp;&nbsp;Endding on ' , UF_GetFormatDate(EndDate,'Eng'),'<br>&nbsp;&nbsp;&nbsp;Instructor: ',concat('<a href="instructor.php?instructorid=',activityschedule.instructorid,'">',instructor.firstname,' ',instructor.Lastname,"</a>"))
) as ScheduleDescription
,if(schedule.startdate < now(),'Y','N') as AlreadyStarted
,activityschedule.ActivityPrice 
,activityschedule.activityscheduleid
,activity.image
from activity
	join activityschedule
	on activity.ActivityID = activityschedule.ActivityID

	    	join location
    		on activityschedule.LocationID = location.LocationID
    
		join schedule
        	on activityschedule.ScheduleID = schedule.ScheduleID

		join person as instructor
		on activityschedule.instructorid = instructor.personid
        
			join scheduletype
            on schedule.ScheduleTypeID = scheduletype.ScheduleTypeID
            
            join scheduleday
            on schedule.ScheduleDayID = scheduleday.ScheduleDayID
    
    join ActivityType
    on Activity.ActivityTypeID = ActivityType.ActivityTypeID
    
    join ActivityLevel
    on activity.ActivityLevelID = ActivityLevel.ActivityLevelID

where Activity.activeind = 'Y'
and activityschedule.activityscheduleid = ActivityScheduleID 
and (Activity.DeactivatedDate is null or Activity.DeactivatedDate = 0)
and Activityschedule.activeind = 'Y'
and (Activityschedule.DeactivatedDate is null or Activityschedule.DeactivatedDate = 0)
and ActivityType.activeind = 'Y'
and (ActivityType.DeactivatedDate is null or ActivityType.DeactivatedDate = 0)
and ActivityLevel.activeind = 'Y'
and (ActivityLevel.DeactivatedDate is null or ActivityLevel.DeactivatedDate = 0)
and Location.activeind = 'Y'
and (Location.DeactivatedDate is null or Location.DeactivatedDate = 0)
and schedule.ActiveIND = 'Y'
and (schedule.DeactivatedDate is null or schedule.DeactivatedDate = 0)
and scheduletype.ActiveIND = 'Y'
and (scheduletype.DeactivatedDate is null or scheduletype.DeactivatedDate = 0)
and scheduleday.ActiveIND = 'Y'
and (scheduleday.DeactivatedDate is null or scheduleday.DeactivatedDate = 0)
and schedule.enddate > now();

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GetActivityScheduleList` (IN `PersonID` INT, IN `language` CHAR(3))  BEGIN

/*set language from month name and day name*/
IF (language = "Fra") THEN
	SET lc_time_names = 'fr_FR';
else
	SET lc_time_names = 'en_US';
END IF;

select Activity.ActivityID
,if(language="Fra",activity.ActivityNameFra, activity.ActivityNameEng) as ActivityName
,if(language="Fra",activity.ActivityDescFra, activity.ActivityDescEng) as ActivityDesc
,Activity.ActivityTypeID
,if(language="Fra",Activitytype.ActivityTypeNameFra, Activitytype.ActivityTypeNameEng) as ActivityTypeName
,Activity.ActivityLevelID
,if(language="Fra",ActivityLevel.ActivityLevelNameFra, ActivityLevel.ActivityLevelNameEng) as ActivityLevelName
,activityschedule.LocationID
,if(language="Fra",location.LocationNameFra, location.LocationNameEng) as Location
,schedule.ScheduleID
,if(language="Fra",schedule.ScheduleNameFra, schedule.ScheduleDescEng) as ScheduleDesc
,schedule.ScheduleTypeID
,if(language="Fra",scheduletype.ScheduleTypeNameFra,scheduletype.ScheduleTypeNameEng) as ScheduleTypeName
,schedule.ScheduleDayID
,if(language="Fra",scheduleday.ScheduleDayNameFra,scheduleday.ScheduleDayNameEng) as ScheduleDayName
,schedule.StartDate
,schedule.EndDate
,schedule.StartTime
,schedule.EndTime
,if(language="Fra",
concat('<strong>',Activity.ActivityNameFra, '</strong> (', ActivityLevelNameFra ,')<br>&nbsp;&nbsp;&nbsp;Tous les '
,if(schedule.ScheduleTypeID = 1,'Jours'
,if(schedule.ScheduleTypeID = 2,scheduleday.ScheduleDayNameFra
,if(schedule.ScheduleTypeID = 3,'mois'
,if(schedule.ScheduleTypeID = 4,'ans',''))))
,' à ', StartTime , '<br>&nbsp;&nbsp;&nbsp;Commencant le ', UF_GetFormatDate(StartDate,'Fra') , '<br>&nbsp;&nbsp;&nbsp;Finissant le ' ,  UF_GetFormatDate(EndDate,'Fra'),'<br>&nbsp;&nbsp;&nbsp;Instructeur: ',concat('<a href="instructor.php?instructorid=',activityschedule.instructorid,'">',instructor.firstname,' ',instructor.Lastname,"</a>"))
,concat('<strong>',Activity.ActivityNameEng, '</strong> (', ActivityLevelNameEng ,')<br>&nbsp;&nbsp;&nbsp;Every '
,if(schedule.ScheduleTypeID = 1,'day'
,if(schedule.ScheduleTypeID = 2,scheduleday.ScheduleDayNameEng
,if(schedule.ScheduleTypeID = 3,'month'
,if(schedule.ScheduleTypeID = 4,'year',''))))
,' at ', StartTime , '<br>&nbsp;&nbsp;&nbsp;Starting on ', UF_GetFormatDate(StartDate,'Eng')  , '<br>&nbsp;&nbsp;&nbsp;Endding on ' , UF_GetFormatDate(EndDate,'Eng'),'<br>&nbsp;&nbsp;&nbsp;Instructor: ',concat('<a href="instructor.php?instructorid=',activityschedule.instructorid,'">',instructor.firstname,' ',instructor.Lastname,"</a>"))
) as ScheduleDescription
,if(schedule.startdate < now(),'Y','N') as AlreadyStarted
,if(ActivityRegistration.personid > 0,'Y','N') as AlreadyRegistered
,activityschedule.ActivityPrice 
,UF_GetActivityTotalPaiment(ActivityRegistration.ActivityRegistrationID ) as TotalPaidAmount
,activityschedule.activityscheduleid
,activity.image
from activity
	join activityschedule
	on activity.ActivityID = activityschedule.ActivityID

	    	join location
    		on activityschedule.LocationID = location.LocationID
    
		join schedule
        	on activityschedule.ScheduleID = schedule.ScheduleID

		join person as instructor
		on activityschedule.instructorid = instructor.personid
        
			join scheduletype
            on schedule.ScheduleTypeID = scheduletype.ScheduleTypeID
            
            join scheduleday
            on schedule.ScheduleDayID = scheduleday.ScheduleDayID
    
    join ActivityType
    on Activity.ActivityTypeID = ActivityType.ActivityTypeID
    
    join ActivityLevel
    on activity.ActivityLevelID = ActivityLevel.ActivityLevelID
    
	left outer join ActivityRegistration 
	on Activity.ActivityID = ActivityRegistration.ActivityID
	and ActivityRegistration.PersonID = PersonID
    
    
where Activity.activeind = 'Y'
and (Activity.DeactivatedDate is null or Activity.DeactivatedDate = 0)
and Activityschedule.activeind = 'Y'
and (Activityschedule.DeactivatedDate is null or Activityschedule.DeactivatedDate = 0)
and ActivityType.activeind = 'Y'
and (ActivityType.DeactivatedDate is null or ActivityType.DeactivatedDate = 0)
and ActivityLevel.activeind = 'Y'
and (ActivityLevel.DeactivatedDate is null or ActivityLevel.DeactivatedDate = 0)
and Location.activeind = 'Y'
and (Location.DeactivatedDate is null or Location.DeactivatedDate = 0)
and schedule.ActiveIND = 'Y'
and (schedule.DeactivatedDate is null or schedule.DeactivatedDate = 0)
and scheduletype.ActiveIND = 'Y'
and (scheduletype.DeactivatedDate is null or scheduletype.DeactivatedDate = 0)
and scheduleday.ActiveIND = 'Y'
and (scheduleday.DeactivatedDate is null or scheduleday.DeactivatedDate = 0)
/*
and Activity.ActivityID not in 
(
	select ActivityID from ActivityRegistration 
	where ActivityRegistration.personID = PersonID and ActiveIND = 'Y'
	and (DeactivatedDate is null or DeactivatedDate = 0)
)
*/
and schedule.enddate > now()
order by AlreadyRegistered, schedule.startdate desc
;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GetPersonScedule` (IN `PersonID` INT, IN `language` CHAR(3))  BEGIN

/*set language from month name and day name*/
IF (language = "Fra") THEN
	SET lc_time_names = 'fr_FR';
else
	SET lc_time_names = 'en_US';
END IF;

WITH recursive Date_Ranges AS 
	(
		select StartDate as Date
        , activity.ActivityNameEng as ActivityNameEng
        , activity.ActivityNameFra as ActivityNameFra
        , if(language="fra",activity.ActivityNameFra,activity.ActivityNameEng) as ActivityName
        , schedule.StartTime
        , schedule.EndDate
        , schedule.ScheduleTypeID
        , schedule.EndTime
        , location.LocationNameEng as LocationNameEng
        , location.LocationNameFra as LocationNameFra
        ,if(language="fra",location.LocationNameFra,location.LocationNameEng) as LocationName
        , activitylevel.ActivityLevelNameEng
        , activitylevel.ActivityLevelNameFra
        from activityregistration
			join activityschedule
            on activityregistration.ActivityID = activityschedule.ActivityID
            
				join activity
                on activityregistration.ActivityID = activity.ActivityID
                
					join location
                    on activityschedule.LocationID = location.LocationID
                    
                    join activitylevel
                    on activity.ActivityLevelID = activitylevel.ActivityLevelID
            
				join schedule
				on activityschedule.ScheduleID = schedule.ScheduleID
                
        where activityregistration.PersonID = PersonID
        AND activityschedule.ActiveIND = 'Y'
        AND (activityschedule.DeactivatedDate IS NULL or activityschedule.DeactivatedDate = '')
        AND activity.ActiveIND = 'Y'
        AND (activity.DeactivatedDate IS NULL or activity.DeactivatedDate = '')
        AND location.ActiveIND = 'Y'
        AND (location.DeactivatedDate IS NULL or location.DeactivatedDate = '')
		AND schedule.ActiveIND = 'Y'
        AND (schedule.DeactivatedDate IS NULL or schedule.DeactivatedDate = '')
        AND activitylevel.ActiveIND = 'Y'
        AND (activitylevel.DeactivatedDate IS NULL or activitylevel.DeactivatedDate = '')
        
		union all
		/*select Date + interval @interval day*/
		
		select IF(ScheduleTypeID = 1, DATE_ADD(Date, INTERVAL 1 day),
				IF(ScheduleTypeID = 2, DATE_ADD(Date, INTERVAL 1 week),
				IF(ScheduleTypeID = 3, DATE_ADD(Date, INTERVAL 1 month),
				IF(ScheduleTypeID = 4, DATE_ADD(Date, INTERVAL 1 year),
				DATE_ADD(Date, INTERVAL 1 day))))), 
                ActivityNameEng,
                ActivityNameFra,
                ActivityName,
                StartTime,
                EndDate,
				ScheduleTypeID,
                EndTime,
                LocationNameEng,
                LocationNameFra,
                LocationName,               
				ActivityLevelNameEng,
				ActivityLevelNameFra
		from Date_Ranges
		where Date < EndDate
	)
	select ActivityNameEng, ActivityNameFra, Date,  StartTime, EndTime, DAYNAME(date), MONTHNAME(date), YEAR(DATE),
    CONCAT(DAYNAME(date), ' ',MONTHNAME(date),' ',DAY(date),', ' ,YEAR(DATE)) AS ActivityDateEng, ActivityName,
    if(language="fra",CONCAT(DAYNAME(date),' ',DAY(date), ' ',MONTHNAME(date),' ',YEAR(DATE)),CONCAT(DAYNAME(date), ' ',MONTHNAME(date),' ',DAY(date),', ' ,YEAR(DATE))) as ActivityDate,
	LocationNameEng, LocationNameFra,
    CONCAT(StartTime,' to ',EndTime) as ScheduleTime,
	ActivityLevelNameEng,
	ActivityLevelNameFra,
    LocationName
    from Date_Ranges
    order by Date, StartTime;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GetUserSubscription` (IN `PersonID` INT, IN `language` CHAR(3))  BEGIN

/*set language from month name and day name*/
IF (language = "Fra") THEN
	SET lc_time_names = 'fr_FR';
else
	SET lc_time_names = 'en_US';
END IF;

SELECT person.FirstName
    , person.LastName 
    ,activitytype.ActivityTypeNameEng
    ,activity.ActivityNameEng
    ,activity.ActivityNameFra
    ,schedule.ScheduleNameEng
    ,scheduleday.ScheduleDayNameEng
    , schedule.StartDate
    ,schedule.EndDate
    ,schedule.StartTime
    ,schedule.EndTime
    ,CONCAT(schedule.StartTime,' to ',schedule.EndTime) as ScheduleTime
    ,location.LocationNameEng
    ,activityregistration.RegistrationDate
    FROM person
    
    join activityregistration
    on person.PersonID = activityregistration.PersonID
    
		left join activity
		on activityregistration.activityID = activity.activityID
        
			left join activitytype
            on activity.ActivityTypeID = activitytype.ActivityTypeID
        
	left join activityschedule
	on activityregistration.activityID = activityschedule.activityID

        left join schedule
        on activityschedule.ScheduleID = schedule.ScheduleID
        
			left join scheduleday
            on schedule.ScheduleDayID = scheduleday.ScheduleDayID
        left join location
        on activityschedule.locationID = location.locationID
    where person.ActiveIND = 'Y'
    and (person.DeactivatedDate IS NULL or person.DeactivatedDate = '')
    and activityschedule.ActiveIND = 'Y'
    and (activityschedule.deactivatedDate is null or activityschedule.deactivatedDate = '')
    and activity.ActiveIND = 'Y'
    and (activity.deactivatedDate is null or activity.deactivatedDate = '')
    and schedule.ActiveIND = 'Y'
    and (schedule.deactivatedDate is null or schedule.deactivatedDate = '')
    and scheduleday.ActiveIND = 'Y'
    and (scheduleday.deactivatedDate is null or scheduleday.deactivatedDate = '')
    and location.ActiveIND = 'Y'
	and (location.deactivatedDate is null or location.deactivatedDate = '') 
    and person.personID = PersonID
    order by schedule.StartDate asc;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `UF_GetActivityTotalPaiment` (`parm_ActivityRegistrationID` INT) RETURNS DECIMAL(10,2) BEGIN
DECLARE RETURNvalue decimal(10,2);
declare val dec(10,2);

set val  = (select sum(AmountPaid) 
FROM activitypaiement 
where activitypaiement.activityregistrationid = parm_ActivityRegistrationID
group by activitypaiement.activityregistrationid);

set RETURNvalue = val;

RETURN RETURNvalue;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `UF_GetFormatDate` (`selecteddate` DATE, `language` CHAR(3)) RETURNS VARCHAR(255) CHARSET utf8mb4 BEGIN
DECLARE RETURNvalue VARCHAR(255);

/*set language from month name and day name*/
IF (language = "Fra") THEN
	SET lc_time_names = 'fr_FR';
else
	SET lc_time_names = 'en_US';
END IF;

if language="Fra" THEN
	set RETURNvalue =  CONCAT(DAYNAME(selecteddate),' ',DAY(selecteddate), ' ',MONTHNAME(selecteddate),' ',YEAR(selecteddate));
ELSE
	set RETURNvalue =  CONCAT(DAYNAME(selecteddate), ' ',MONTHNAME(selecteddate),' ',DAY(selecteddate),', ' ,YEAR(selecteddate));
END IF;
RETURN RETURNvalue;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `ActivityID` int(11) NOT NULL,
  `ActivityNameEng` varchar(64) NOT NULL,
  `ActivityNameFra` varchar(64) NOT NULL,
  `ActivityDescEng` varchar(128) DEFAULT NULL,
  `ActivityDescFra` varchar(128) DEFAULT NULL,
  `ActivityTypeID` int(11) NOT NULL,
  `ActivityLevelID` int(11) NOT NULL,
  `OLDLocationID` int(11) NOT NULL,
  `ActivityPolicyEng` varchar(512) DEFAULT NULL,
  `ActivityPolicyFra` varchar(512) DEFAULT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `Image` varchar(128) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`ActivityID`, `ActivityNameEng`, `ActivityNameFra`, `ActivityDescEng`, `ActivityDescFra`, `ActivityTypeID`, `ActivityLevelID`, `OLDLocationID`, `ActivityPolicyEng`, `ActivityPolicyFra`, `ActiveIND`, `Image`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(2, 'Yoga for woman', 'Yoga pour femme', NULL, NULL, 1, 1, 1, NULL, NULL, 'Y', 'y6.jpg', '2020-08-02 11:16:09', 1, '2020-08-02 11:16:09', NULL, NULL, NULL),
(3, 'Yoga for kids', 'Yoga pour enfants', NULL, NULL, 1, 2, 2, NULL, NULL, 'Y', 'y5.jpg', '2020-08-02 11:17:21', 1, '2020-08-02 11:17:21', NULL, NULL, NULL),
(4, 'Hot Yoga', 'Yoga chaud', NULL, NULL, 1, 3, 3, NULL, NULL, 'Y', 'y4.jpg', '2020-08-02 11:18:07', 1, '2020-08-02 11:18:07', NULL, NULL, NULL),
(5, 'Taichi for 50 years  old and over', 'Taichi pour 50 ans et plus', NULL, NULL, 2, 1, 3, NULL, NULL, 'Y', 'y7.jpg', '2020-08-02 11:19:18', 1, '2020-08-02 11:19:18', NULL, NULL, NULL),
(6, 'Pilate for woman', 'Pilate pour femme', NULL, NULL, 3, 2, 2, NULL, NULL, 'Y', 'y8.jpeg', '2020-08-02 11:20:21', 1, '2020-08-02 11:20:21', NULL, NULL, NULL),
(8, 'Yoga for cat', 'Yoga pour chat', NULL, NULL, 1, 1, 0, NULL, NULL, 'Y', 'y10.jpeg', '2020-08-25 08:58:30', 1, '2020-08-25 08:58:30', NULL, NULL, NULL);

--
-- Triggers `activity`
--
DELIMITER $$
CREATE TRIGGER `TRI_ActivityCreatedDate` BEFORE INSERT ON `activity` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activitylevel`
--

CREATE TABLE `activitylevel` (
  `ActivityLevelID` int(11) NOT NULL,
  `ActivityLevelNameEng` varchar(64) NOT NULL,
  `ActivityLevelNameFra` varchar(64) NOT NULL,
  `ActivityLevelDescEng` varchar(128) DEFAULT NULL,
  `ActivityLevelDescFra` varchar(128) DEFAULT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activitylevel`
--

INSERT INTO `activitylevel` (`ActivityLevelID`, `ActivityLevelNameEng`, `ActivityLevelNameFra`, `ActivityLevelDescEng`, `ActivityLevelDescFra`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 'Beginer', 'Débutant', NULL, NULL, 'Y', '2020-08-02 11:11:54', 1, '2020-08-02 15:11:54', NULL, NULL, NULL),
(2, 'Intermediate', 'Intermédiaire', NULL, NULL, 'Y', '2020-08-02 11:11:54', 1, '2020-08-02 15:11:54', NULL, NULL, NULL),
(3, 'Advance', 'Avancé', NULL, NULL, 'Y', '2020-08-02 11:12:54', 1, '2020-08-02 15:12:54', NULL, NULL, NULL),
(4, 'Level 1', 'Niveau 1', NULL, NULL, 'Y', '2020-08-02 11:13:58', 0, '2020-08-02 15:13:58', NULL, NULL, NULL),
(5, 'Level 2', 'Niveau 2', NULL, NULL, 'Y', '2020-08-02 11:13:58', 0, '2020-08-02 15:13:58', NULL, NULL, NULL),
(6, 'Level 3', 'Niveau 3', NULL, NULL, 'Y', '2020-08-02 11:14:15', 0, '2020-08-02 15:14:15', NULL, NULL, NULL);

--
-- Triggers `activitylevel`
--
DELIMITER $$
CREATE TRIGGER `TRI_ActivityLevelCreatedDate` BEFORE INSERT ON `activitylevel` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activitypaiement`
--

CREATE TABLE `activitypaiement` (
  `ActivityPaiementID` int(11) NOT NULL,
  `ActivityRegistrationID` int(11) NOT NULL,
  `AmountPaid` decimal(10,2) DEFAULT NULL,
  `PaiementTypeID` int(11) DEFAULT NULL,
  `DateOfPaiement` date NOT NULL,
  `CreatedDate` date DEFAULT NULL,
  `CreatedUserID` int(11) DEFAULT NULL,
  `ModifiedDate` date DEFAULT NULL,
  `ModifiedUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` date NOT NULL,
  `DeactivatedUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activitypaiement`
--

INSERT INTO `activitypaiement` (`ActivityPaiementID`, `ActivityRegistrationID`, `AmountPaid`, `PaiementTypeID`, `DateOfPaiement`, `CreatedDate`, `CreatedUserID`, `ModifiedDate`, `ModifiedUserID`, `DeactivatedDate`, `DeactivatedUserID`) VALUES
(1, 1, '60.00', 6, '2020-08-01', '2020-08-13', 1, NULL, NULL, '0000-00-00', NULL),
(2, 1, '44.00', 3, '2020-08-01', NULL, 1, NULL, NULL, '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activityregistration`
--

CREATE TABLE `activityregistration` (
  `ActivityRegistrationID` int(11) NOT NULL,
  `ActivityID` int(11) NOT NULL,
  `PersonID` int(11) NOT NULL,
  `RegistrationDate` date DEFAULT NULL,
  `ActiveIND` char(1) DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activityregistration`
--

INSERT INTO `activityregistration` (`ActivityRegistrationID`, `ActivityID`, `PersonID`, `RegistrationDate`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 2, 3, '2020-07-01', 'Y', '2020-08-02 11:53:31', 1, '2020-08-02 15:53:31', 1, NULL, NULL),
(2, 6, 4, '2020-07-14', 'Y', '2020-08-02 11:53:31', 1, '2020-08-02 15:53:31', 4, NULL, NULL),
(3, 3, 6, '2020-07-05', 'Y', '2020-08-02 11:55:28', 1, '2020-08-02 15:55:28', 6, NULL, NULL);

--
-- Triggers `activityregistration`
--
DELIMITER $$
CREATE TRIGGER `TRI_RASCreatedDate` BEFORE INSERT ON `activityregistration` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activityschedule`
--

CREATE TABLE `activityschedule` (
  `ActivityScheduleID` int(11) NOT NULL,
  `ActivityID` int(11) NOT NULL,
  `ScheduleID` int(11) NOT NULL,
  `InstructorID` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL,
  `ActivityPrice` decimal(10,2) DEFAULT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activityschedule`
--

INSERT INTO `activityschedule` (`ActivityScheduleID`, `ActivityID`, `ScheduleID`, `InstructorID`, `LocationID`, `ActivityPrice`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 2, 1, 6, 1, '122.00', 'Y', '2020-08-02 11:50:59', 1, '2020-08-02 15:50:59', 1, NULL, NULL),
(2, 3, 2, 4, 2, '131.50', 'Y', '2020-08-02 11:51:43', 1, '2020-08-02 15:51:43', NULL, NULL, NULL),
(3, 4, 3, 17, 3, '100.00', 'Y', '2020-08-02 11:51:43', 1, '2020-08-02 15:51:43', NULL, NULL, NULL),
(4, 5, 4, 25, 3, '165.00', 'Y', '2020-08-02 11:52:42', 1, '2020-08-02 15:52:42', NULL, NULL, NULL),
(5, 6, 4, 41, 2, '199.00', 'Y', '2020-08-02 11:52:42', 1, '2020-08-02 15:52:42', NULL, NULL, NULL),
(6, 8, 5, 43, 2, '88.00', 'Y', '2020-08-25 09:03:39', 1, '2020-08-25 13:03:39', NULL, NULL, NULL);

--
-- Triggers `activityschedule`
--
DELIMITER $$
CREATE TRIGGER `TRI_ActivityScheduleCreatedDate` BEFORE INSERT ON `activityschedule` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activitytype`
--

CREATE TABLE `activitytype` (
  `ActivityTypeID` int(11) NOT NULL,
  `ActivityTypeNameEng` varchar(64) NOT NULL,
  `ActivityTypeNameFra` varchar(64) NOT NULL,
  `ActivityTypeDescEng` varchar(128) DEFAULT NULL,
  `ActivityTypeDescFra` varchar(128) DEFAULT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activitytype`
--

INSERT INTO `activitytype` (`ActivityTypeID`, `ActivityTypeNameEng`, `ActivityTypeNameFra`, `ActivityTypeDescEng`, `ActivityTypeDescFra`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 'Yoga', 'Yoga', NULL, NULL, 'Y', '2020-08-02 11:14:57', 1, '2020-08-02 15:14:57', NULL, NULL, NULL),
(2, 'Taichi', 'Taichi', NULL, NULL, 'Y', '2020-08-02 11:14:57', 1, '2020-08-02 15:14:57', NULL, NULL, NULL),
(3, 'Pilate', 'Pilate', NULL, NULL, 'Y', '2020-08-02 11:15:18', 1, '2020-08-02 15:15:18', NULL, NULL, NULL);

--
-- Triggers `activitytype`
--
DELIMITER $$
CREATE TRIGGER `TRI_ActivityTypeCreatedDate` BEFORE INSERT ON `activitytype` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LocationID` int(11) NOT NULL,
  `LocationNameEng` varchar(64) NOT NULL,
  `LocationNameFra` varchar(64) NOT NULL,
  `LocationDescriptionEng` varchar(128) DEFAULT NULL,
  `LocationDescriptionFra` varchar(128) DEFAULT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocationID`, `LocationNameEng`, `LocationNameFra`, `LocationDescriptionEng`, `LocationDescriptionFra`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, '303 rue De Melbourne, Room 5', '3030 rue de Melbourne, salle 5', NULL, NULL, 'Y', '2020-08-02 10:49:37', 1, '2020-08-02 14:49:37', NULL, '0000-00-00 00:00:00', NULL),
(2, '120 St-Joseph, Room 22', '120 St-Joseph, salle 22', NULL, NULL, 'Y', '2020-08-02 10:50:32', 1, '2020-08-02 14:50:32', NULL, '0000-00-00 00:00:00', NULL),
(3, '105 Pavillion noire, App #33, room 987, Gatineau, QC', '105 Pavillion noire, App #33, salle 987, Gatineau, QC', NULL, NULL, 'Y', '2020-08-02 10:51:38', 1, '2020-08-02 14:51:38', NULL, '0000-00-00 00:00:00', NULL);

--
-- Triggers `location`
--
DELIMITER $$
CREATE TRIGGER `TRI_LocationCreatedDate` BEFORE INSERT ON `location` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `paiementtype`
--

CREATE TABLE `paiementtype` (
  `PaiementTypeID` int(11) NOT NULL,
  `PaiementTypeNameEng` varchar(64) NOT NULL,
  `PaiementTypeNameFra` varchar(64) NOT NULL,
  `CreatedDate` date NOT NULL,
  `CreatedUserID` int(11) NOT NULL,
  `ModifiedDate` date DEFAULT NULL,
  `ModifiedUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` date DEFAULT NULL,
  `DeactivatedUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paiementtype`
--

INSERT INTO `paiementtype` (`PaiementTypeID`, `PaiementTypeNameEng`, `PaiementTypeNameFra`, `CreatedDate`, `CreatedUserID`, `ModifiedDate`, `ModifiedUserID`, `DeactivatedDate`, `DeactivatedUserID`) VALUES
(1, 'Cash', 'Comptant', '2020-08-13', 1, NULL, NULL, NULL, NULL),
(2, 'Debit', 'Debit', '2020-08-13', 1, NULL, NULL, NULL, NULL),
(3, 'Master Card', 'Master Card', '2020-08-13', 1, NULL, NULL, NULL, NULL),
(4, 'Visa', 'Visa', '2020-08-13', 1, NULL, NULL, NULL, NULL),
(5, 'Paypal', 'Paypal', '2020-08-13', 1, NULL, NULL, NULL, NULL),
(6, 'Check', 'Cheque', '2020-08-13', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `PersonID` int(11) NOT NULL,
  `PersonTypeID` int(11) NOT NULL,
  `FirstName` varchar(128) NOT NULL,
  `LastName` varchar(128) NOT NULL,
  `UserName` varchar(32) NOT NULL,
  `Password` char(255) NOT NULL,
  `PasswordExpiryDate` date DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Language` varchar(4) DEFAULT 'Eng',
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `ConfirmedIND` char(1) DEFAULT 'N',
  `AddressStreet` varchar(128) DEFAULT NULL,
  `AddressCity` varchar(32) DEFAULT NULL,
  `AddressProvinceID` int(11) DEFAULT NULL,
  `AddressPostalCode` char(8) DEFAULT NULL,
  `Email` varchar(128) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `Note` text DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`PersonID`, `PersonTypeID`, `FirstName`, `LastName`, `UserName`, `Password`, `PasswordExpiryDate`, `Gender`, `DateOfBirth`, `Language`, `ActiveIND`, `ConfirmedIND`, `AddressStreet`, `AddressCity`, `AddressProvinceID`, `AddressPostalCode`, `Email`, `PhoneNumber`, `Note`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 1, 'Frank', 'Lance', 'lancef', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', '2020-09-04', 'M', NULL, 'Eng', 'Y', 'N', '11 blabla', 'Gatineau', 9, 'J9T8I9', 'serge@comada.ca', NULL, 'bla bla bla long text', '2020-08-02 11:32:00', 1, '2020-07-13 23:25:17', NULL, NULL, NULL),
(2, 2, 'Serge', 'Samson', 'samsons', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, 'M', NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-02 11:32:00', 0, '2020-07-13 23:31:52', NULL, NULL, NULL),
(3, 3, 'Valerie', 'Samson', 'samsonv', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, 'F', '1993-03-06', 'Fra', 'Y', 'N', '404 petit pont', 'Masson', 9, '', 'yo@yahoo.com', '222-222-2233', NULL, '2020-08-02 11:32:00', 1, '2020-07-15 19:10:31', 3, NULL, NULL),
(4, 3, 'Andrée', 'Daviau', 'daviaua', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, 'F', '0000-00-00', 'Fra', 'Y', 'N', '303 rue de Melbourne', 'Gatineau', 9, 'J8T8R2', 'adaviau@videotron.ca', '', 'belle mere a Frank', '2020-08-02 11:32:00', 1, '2020-07-14 21:39:06', 4, NULL, NULL),
(6, 3, 'Black', 'Jack', 'jackb', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, 'M', NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-02 11:54:54', 1, '2020-08-02 15:54:54', NULL, NULL, NULL),
(15, 3, '', '', 'moka', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-07 10:46:02', 0, '2020-08-07 14:46:02', NULL, NULL, NULL),
(17, 3, 'Kira', 'Samson', 'kira', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-07 11:33:01', 0, '2020-08-07 15:33:01', NULL, NULL, NULL),
(19, 3, 'bozo', 'leclown', 'bozo', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-07 13:30:19', 0, '2020-08-07 17:30:19', NULL, NULL, NULL),
(21, 3, 'aldo', 'nova', 'aldo', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-07 13:43:41', 0, '2020-08-07 17:43:41', NULL, NULL, NULL),
(23, 3, 'Clack', 'Kent', 'superman', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-07 13:58:59', 0, '2020-08-07 17:58:59', NULL, NULL, NULL),
(25, 3, 'james', 'bond', 'james', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-07 14:07:23', 0, '2020-08-07 18:07:23', NULL, NULL, NULL),
(27, 3, 'elvis', 'gratton', 'elvis', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-07 14:22:28', 0, '2020-08-07 18:22:28', NULL, NULL, NULL),
(29, 3, 's', 'Samson', 'comadatech', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-10 11:10:40', 0, '2020-08-10 15:10:40', NULL, NULL, NULL),
(31, 3, 'Guy', 'Lalom', 'laloma', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-10 12:06:37', 0, '2020-08-10 16:06:37', NULL, NULL, NULL),
(33, 3, 'Francis', 'Samson', 'samsonfa', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, 'M', '0000-00-00', 'Eng', 'Y', 'N', '', '', 1, '', 'serge@comada.ca', '', NULL, '2020-08-10 12:23:42', 0, '2020-08-10 16:23:42', 33, NULL, NULL),
(35, 3, 'Manon', 'Salon', 'salonm', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, '3otto3comadatech@gmail.com', NULL, NULL, '2020-08-10 16:23:16', 0, '2020-08-10 20:23:16', NULL, NULL, NULL),
(37, 3, 'Sylvie', 'Malo', 'malos', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'tiii@ededed.com', NULL, NULL, '2020-08-10 16:39:24', 0, '2020-08-10 20:39:24', NULL, NULL, NULL),
(39, 3, 'kira', 'Samson', 'jambong', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, 'M', '1993-03-06', 'Eng', 'Y', 'N', '404 petit pont  #22', 'Masson', 1, 'J8T 8R4', 'serge@comada.ca', '222-222-2222', NULL, '2020-08-10 17:22:29', 0, '2020-08-10 21:22:29', 39, NULL, NULL),
(41, 3, 'Markus', 'Naslund', 'naslevas', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge_samson@yahoo.com', NULL, NULL, '2020-08-10 17:24:40', 0, '2020-08-10 21:24:40', NULL, NULL, NULL),
(43, 3, 'chien', 'chaud', 'chaudc', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-10 17:25:47', 0, '2020-08-10 21:25:47', NULL, NULL, NULL),
(45, 3, 'New', 'York', 'City', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-10 17:35:35', 0, '2020-08-10 21:35:35', NULL, NULL, NULL),
(47, 3, 'Mr.', 'Roboto', 'Robot', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge_samson@yahoo.com', NULL, NULL, '2020-08-10 17:55:52', 0, '2020-08-10 21:55:52', NULL, NULL, NULL),
(49, 3, 'Sapin', 'Denoel', 'noels', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, '3otto3comada@gmail.com', NULL, NULL, '2020-08-10 17:57:58', 0, '2020-08-10 21:57:58', NULL, NULL, NULL),
(51, 3, 'cocho', 'pierre', 'zinzin', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge_samson@yahoo.com', NULL, NULL, '2020-08-10 18:29:27', 0, '2020-08-10 22:29:27', NULL, NULL, NULL),
(53, 3, 'dodo', 'nono', 'laks', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, '3otto3comada@gmail.com', NULL, NULL, '2020-08-10 18:30:50', 0, '2020-08-10 22:30:50', NULL, NULL, NULL),
(55, 3, 'chocolat', 'lapin', 'malin', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, 'F', '1993-03-06', 'Eng', 'Y', 'N', '404 petit pont', 'Masson', 7, '', 'serge_samson@yahoo.com', '222-222-2222', NULL, '2020-08-10 18:32:00', 0, '2020-08-10 22:32:00', 55, NULL, NULL),
(57, 3, 'Pin', 'chaud', 'chaudp', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-14 14:41:45', 0, '2020-08-14 18:41:45', NULL, NULL, NULL),
(59, 3, 'Jimmy', 'Hendrix', 'hend', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-14 14:54:31', 0, '2020-08-14 18:54:31', NULL, NULL, NULL),
(61, 3, 'Van', 'Hallen', 'halv', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge_samson@yahoo.com', NULL, NULL, '2020-08-14 14:57:34', 0, '2020-08-14 18:57:34', NULL, NULL, NULL),
(63, 3, 'pinute', 'cerise', 'ssss', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge@comada.ca', NULL, NULL, '2020-08-17 19:59:53', 0, '2020-08-17 23:59:53', NULL, NULL, NULL),
(65, 3, 'wife', 'fan', 'time', '$2y$10$FCmdImbsZzuAfcO3tC2Xe.G8EdE8r/vSqlYCRU/ntV46gkG8qRbq.', NULL, NULL, NULL, 'Eng', 'Y', 'N', NULL, NULL, NULL, NULL, 'serge_samson@yahoo.com', NULL, NULL, '2020-08-17 20:02:43', 0, '2020-08-18 00:02:43', NULL, NULL, NULL);

--
-- Triggers `person`
--
DELIMITER $$
CREATE TRIGGER `TRI_PersonCreatedDate` BEFORE INSERT ON `person` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `persontype`
--

CREATE TABLE `persontype` (
  `PersonTypeID` int(11) NOT NULL,
  `PersonTypeNameEng` varchar(64) NOT NULL,
  `PersonTypeNameFra` varchar(64) NOT NULL,
  `PersonTypeDescEng` varchar(128) DEFAULT NULL,
  `PersonTypeDescFra` varchar(128) DEFAULT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `persontype`
--

INSERT INTO `persontype` (`PersonTypeID`, `PersonTypeNameEng`, `PersonTypeNameFra`, `PersonTypeDescEng`, `PersonTypeDescFra`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 'System Admin', 'Administrateur', NULL, NULL, 'Y', '2020-08-02 10:47:33', 1, '2020-08-02 14:47:33', NULL, NULL, NULL),
(2, 'Teacher', 'Enseignant', NULL, NULL, 'Y', '2020-08-02 10:48:29', 1, '2020-08-02 14:48:29', NULL, NULL, NULL),
(3, 'Student/Customer', 'Étudiant/Client', NULL, NULL, 'Y', '2020-08-02 10:48:29', 1, '2020-08-02 14:48:29', NULL, NULL, NULL);

--
-- Triggers `persontype`
--
DELIMITER $$
CREATE TRIGGER `TRI_PersonTypeCreatedDate` BEFORE INSERT ON `persontype` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `ProvinceID` int(11) NOT NULL,
  `ProvinceName` varchar(64) NOT NULL,
  `ProvinceAbbreviation` char(2) NOT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`ProvinceID`, `ProvinceName`, `ProvinceAbbreviation`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 'Alberta', 'AB', 'Y', '2020-08-02 10:11:53', 1, '2020-08-02 14:11:53', NULL, NULL, NULL),
(2, 'British Columbia', 'BC', 'Y', '2020-08-02 10:11:53', 1, '2020-08-02 14:11:53', NULL, NULL, NULL),
(3, 'Manitoba', 'MB', 'Y', '2020-08-02 10:19:54', 1, '2020-08-02 14:19:54', NULL, NULL, NULL),
(4, 'New Brunswick', 'NB', 'Y', '2020-08-02 10:19:54', 1, '2020-08-02 14:19:54', NULL, NULL, NULL),
(5, 'Newfoundland and Labrador', 'NL', 'Y', '2020-08-02 10:27:50', 1, '2020-08-02 14:27:50', NULL, NULL, NULL),
(6, 'Nova Scotia', 'NS', 'Y', '2020-08-02 10:27:50', 1, '2020-08-02 14:27:50', NULL, NULL, NULL),
(7, 'Ontario', 'ON', 'Y', '2020-08-02 10:29:09', 1, '2020-08-02 14:29:09', NULL, NULL, NULL),
(8, 'Prince Edward Island', 'PE', 'Y', '2020-08-02 10:29:09', 1, '2020-08-02 14:29:09', NULL, NULL, NULL),
(9, 'Quebec', 'QC', 'Y', '2020-08-02 10:29:48', 1, '2020-08-02 14:29:48', NULL, NULL, NULL),
(10, 'Saskatchewan', 'SK', 'Y', '2020-08-02 10:29:48', 1, '2020-08-02 14:29:48', NULL, NULL, NULL),
(11, 'Northwest Territories', 'NT', 'Y', '2020-08-02 10:30:37', 1, '2020-08-02 14:30:37', NULL, NULL, NULL),
(12, 'Nunavut', 'NU', 'Y', '2020-08-02 10:30:37', 1, '2020-08-02 14:30:37', NULL, NULL, NULL),
(13, 'Yukon', 'YT', 'Y', '2020-08-02 10:30:57', 1, '2020-08-02 14:30:57', NULL, NULL, NULL);

--
-- Triggers `province`
--
DELIMITER $$
CREATE TRIGGER `TRI_ProvinceCreatedDate` BEFORE INSERT ON `province` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ScheduleID` int(11) NOT NULL,
  `ScheduleNameEng` varchar(64) NOT NULL,
  `ScheduleNameFra` varchar(64) NOT NULL,
  `ScheduleDescEng` varchar(128) DEFAULT NULL,
  `ScheduleDescFra` varchar(128) DEFAULT NULL,
  `ScheduleTypeID` int(11) NOT NULL,
  `ScheduleDayID` int(11) NOT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date NOT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ScheduleID`, `ScheduleNameEng`, `ScheduleNameFra`, `ScheduleDescEng`, `ScheduleDescFra`, `ScheduleTypeID`, `ScheduleDayID`, `StartDate`, `EndDate`, `StartTime`, `EndTime`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 'Monday8h00', 'Lundi8h00', NULL, NULL, 2, 1, '2020-07-20', '2020-11-13', '08:00:00', '09:00:00', 'Y', '2020-08-02 11:37:43', 1, '2020-08-02 15:37:43', NULL, NULL, NULL),
(2, 'Wednesday13h00', 'Mercredi13h00', NULL, NULL, 2, 3, '2020-08-20', '2020-12-12', '19:30:00', '20:30:00', 'Y', '2020-08-02 11:39:20', 1, '2020-08-02 15:39:20', NULL, NULL, NULL),
(3, 'Thurday10h00', 'Jeudi10h00', NULL, NULL, 2, 4, '2020-09-09', '2021-02-02', '10:00:00', '11:00:00', 'Y', '2020-08-02 11:40:53', 1, '2020-08-02 15:40:53', NULL, NULL, NULL),
(4, 'EveryDay', 'TousLesJours', NULL, NULL, 1, 5, '2020-07-27', '2020-08-31', '14:00:00', '15:00:00', 'Y', '2020-08-02 11:42:44', 1, '2020-08-02 15:42:44', NULL, NULL, NULL),
(5, 'Tuesday 9AM', 'Mardi 9:00', NULL, NULL, 2, 2, '2020-09-01', '2020-12-01', '09:00:00', '10:00:00', 'Y', '2020-08-25 09:02:15', 1, '2020-08-25 13:02:15', NULL, NULL, NULL);

--
-- Triggers `schedule`
--
DELIMITER $$
CREATE TRIGGER `TRI_ScheduleCreatedDate` BEFORE INSERT ON `schedule` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `scheduleday`
--

CREATE TABLE `scheduleday` (
  `ScheduleDayID` int(11) NOT NULL,
  `ScheduleDayNameEng` varchar(64) NOT NULL,
  `ScheduleDayNameFra` varchar(64) NOT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scheduleday`
--

INSERT INTO `scheduleday` (`ScheduleDayID`, `ScheduleDayNameEng`, `ScheduleDayNameFra`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 'Monday', 'Lundi', 'Y', '2020-08-02 10:45:27', 1, '2020-08-02 14:45:27', NULL, NULL, NULL),
(2, 'Tuesday', 'Mardi', 'Y', '2020-08-02 10:45:27', 1, '2020-08-02 14:45:27', NULL, NULL, NULL),
(3, 'Wednesday', 'Mercredi', 'Y', '2020-08-02 10:45:56', 1, '2020-08-02 14:45:56', NULL, NULL, NULL),
(4, 'Thursday', 'Jeudi', 'Y', '2020-08-02 10:45:56', 1, '2020-08-02 14:45:56', NULL, NULL, NULL),
(5, 'Friday', 'Vendredi', 'Y', '2020-08-02 10:46:38', 1, '2020-08-02 14:46:38', NULL, NULL, NULL),
(6, 'Saturday', 'Samedi', 'Y', '2020-08-02 10:46:38', 1, '2020-08-02 14:46:38', NULL, NULL, NULL),
(7, 'Sunday', 'Dimanche', 'Y', '2020-08-02 10:46:58', 1, '2020-08-02 14:46:58', NULL, NULL, NULL);

--
-- Triggers `scheduleday`
--
DELIMITER $$
CREATE TRIGGER `TRI_ScheduleDayCreatedDate` BEFORE INSERT ON `scheduleday` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `scheduletype`
--

CREATE TABLE `scheduletype` (
  `ScheduleTypeID` int(11) NOT NULL,
  `ScheduleTypeNameEng` varchar(64) NOT NULL,
  `ScheduleTypeNameFra` varchar(64) NOT NULL,
  `ActiveIND` char(1) NOT NULL DEFAULT 'Y',
  `CreatedDate` datetime NOT NULL,
  `CreatedByUserID` int(11) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT current_timestamp(),
  `ModifiedByUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` datetime DEFAULT NULL,
  `DeactivatedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scheduletype`
--

INSERT INTO `scheduletype` (`ScheduleTypeID`, `ScheduleTypeNameEng`, `ScheduleTypeNameFra`, `ActiveIND`, `CreatedDate`, `CreatedByUserID`, `ModifiedDate`, `ModifiedByUserID`, `DeactivatedDate`, `DeactivatedByUserID`) VALUES
(1, 'Daily', 'Journalier', 'Y', '2020-08-02 11:27:57', 1, NULL, NULL, NULL, NULL),
(2, 'Weekly', 'Hebdomadaire', 'Y', '2020-08-02 11:27:57', 1, NULL, NULL, NULL, NULL),
(3, 'Monthly', 'Mensuel', 'Y', '2020-08-02 11:27:57', 1, NULL, NULL, NULL, NULL),
(4, 'Yearly', 'Annuelle', 'Y', '2020-08-02 11:27:57', 1, NULL, NULL, NULL, NULL),
(5, 'One Time', 'Une fois', 'Y', '2020-08-02 11:27:57', 1, NULL, NULL, NULL, NULL);

--
-- Triggers `scheduletype`
--
DELIMITER $$
CREATE TRIGGER `TRI_ScheduleTypeCreatedDate` BEFORE INSERT ON `scheduletype` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `taxrate`
--

CREATE TABLE `taxrate` (
  `TaxRateID` int(11) NOT NULL,
  `TaxNameEng` varchar(32) NOT NULL,
  `TaxNameFra` varchar(32) NOT NULL,
  `Percentage` decimal(5,3) NOT NULL,
  `StartDate` date NOT NULL,
  `CreatedDate` date NOT NULL,
  `ActiveIND` char(1) DEFAULT 'Y',
  `CreatedByUserID` int(11) NOT NULL,
  `ModifieDate` date DEFAULT NULL,
  `ModifiedUserID` int(11) DEFAULT NULL,
  `DeactivatedDate` date DEFAULT NULL,
  `DeactivatedUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taxrate`
--

INSERT INTO `taxrate` (`TaxRateID`, `TaxNameEng`, `TaxNameFra`, `Percentage`, `StartDate`, `CreatedDate`, `ActiveIND`, `CreatedByUserID`, `ModifieDate`, `ModifiedUserID`, `DeactivatedDate`, `DeactivatedUserID`) VALUES
(1, 'QST', '', '9.975', '2020-05-01', '0000-00-00', 'N', 1, NULL, NULL, NULL, NULL),
(2, 'GST', '', '10.000', '0000-00-00', '0000-00-00', 'Y', 1, NULL, NULL, NULL, NULL);

--
-- Triggers `taxrate`
--
DELIMITER $$
CREATE TRIGGER `TRI_TaxRateCreatedDate` BEFORE INSERT ON `taxrate` FOR EACH ROW SET NEW.CreatedDate = 
DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`ActivityID`),
  ADD KEY `ActivityLevel` (`ActivityLevelID`),
  ADD KEY `ActivityType` (`ActivityTypeID`);

--
-- Indexes for table `activitylevel`
--
ALTER TABLE `activitylevel`
  ADD PRIMARY KEY (`ActivityLevelID`);

--
-- Indexes for table `activitypaiement`
--
ALTER TABLE `activitypaiement`
  ADD PRIMARY KEY (`ActivityPaiementID`),
  ADD KEY `PaimentType` (`PaiementTypeID`),
  ADD KEY `ActivityRegistration` (`ActivityRegistrationID`);

--
-- Indexes for table `activityregistration`
--
ALTER TABLE `activityregistration`
  ADD PRIMARY KEY (`ActivityRegistrationID`),
  ADD KEY `ActivityPerson` (`PersonID`),
  ADD KEY `ActivityRegActivity` (`ActivityID`);

--
-- Indexes for table `activityschedule`
--
ALTER TABLE `activityschedule`
  ADD PRIMARY KEY (`ActivityScheduleID`),
  ADD KEY `Schedule` (`ScheduleID`),
  ADD KEY `Activity` (`ActivityID`),
  ADD KEY `ScheduleLocation` (`LocationID`),
  ADD KEY `Instructor` (`InstructorID`);

--
-- Indexes for table `activitytype`
--
ALTER TABLE `activitytype`
  ADD PRIMARY KEY (`ActivityTypeID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`);

--
-- Indexes for table `paiementtype`
--
ALTER TABLE `paiementtype`
  ADD PRIMARY KEY (`PaiementTypeID`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`PersonID`),
  ADD UNIQUE KEY `UC_PersonUserName` (`UserName`),
  ADD KEY `PersonType` (`PersonTypeID`),
  ADD KEY `AddressProvince` (`AddressProvinceID`);

--
-- Indexes for table `persontype`
--
ALTER TABLE `persontype`
  ADD PRIMARY KEY (`PersonTypeID`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`ProvinceID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ScheduleID`),
  ADD KEY `ScheduleType` (`ScheduleTypeID`),
  ADD KEY `ScheduleDay` (`ScheduleDayID`);

--
-- Indexes for table `scheduleday`
--
ALTER TABLE `scheduleday`
  ADD PRIMARY KEY (`ScheduleDayID`);

--
-- Indexes for table `scheduletype`
--
ALTER TABLE `scheduletype`
  ADD PRIMARY KEY (`ScheduleTypeID`);

--
-- Indexes for table `taxrate`
--
ALTER TABLE `taxrate`
  ADD PRIMARY KEY (`TaxRateID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `ActivityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `activitylevel`
--
ALTER TABLE `activitylevel`
  MODIFY `ActivityLevelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `activitypaiement`
--
ALTER TABLE `activitypaiement`
  MODIFY `ActivityPaiementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `activityregistration`
--
ALTER TABLE `activityregistration`
  MODIFY `ActivityRegistrationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `activityschedule`
--
ALTER TABLE `activityschedule`
  MODIFY `ActivityScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `activitytype`
--
ALTER TABLE `activitytype`
  MODIFY `ActivityTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paiementtype`
--
ALTER TABLE `paiementtype`
  MODIFY `PaiementTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `PersonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `persontype`
--
ALTER TABLE `persontype`
  MODIFY `PersonTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `ProvinceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scheduleday`
--
ALTER TABLE `scheduleday`
  MODIFY `ScheduleDayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `scheduletype`
--
ALTER TABLE `scheduletype`
  MODIFY `ScheduleTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `taxrate`
--
ALTER TABLE `taxrate`
  MODIFY `TaxRateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `ActivityLevel` FOREIGN KEY (`ActivityLevelID`) REFERENCES `activitylevel` (`ActivityLevelID`),
  ADD CONSTRAINT `ActivityType` FOREIGN KEY (`ActivityTypeID`) REFERENCES `activitytype` (`ActivityTypeID`);

--
-- Constraints for table `activitypaiement`
--
ALTER TABLE `activitypaiement`
  ADD CONSTRAINT `ActivityRegistration` FOREIGN KEY (`ActivityRegistrationID`) REFERENCES `activityregistration` (`ActivityRegistrationID`),
  ADD CONSTRAINT `PaimentType` FOREIGN KEY (`PaiementTypeID`) REFERENCES `paiementtype` (`PaiementTypeID`);

--
-- Constraints for table `activityregistration`
--
ALTER TABLE `activityregistration`
  ADD CONSTRAINT `ActivityPerson` FOREIGN KEY (`PersonID`) REFERENCES `person` (`PersonID`),
  ADD CONSTRAINT `ActivityRegActivity` FOREIGN KEY (`ActivityID`) REFERENCES `activity` (`ActivityID`);

--
-- Constraints for table `activityschedule`
--
ALTER TABLE `activityschedule`
  ADD CONSTRAINT `Activity` FOREIGN KEY (`ActivityID`) REFERENCES `activity` (`ActivityID`),
  ADD CONSTRAINT `Instructor` FOREIGN KEY (`InstructorID`) REFERENCES `person` (`PersonID`),
  ADD CONSTRAINT `Schedule` FOREIGN KEY (`ScheduleID`) REFERENCES `schedule` (`ScheduleID`),
  ADD CONSTRAINT `ScheduleLocation` FOREIGN KEY (`LocationID`) REFERENCES `location` (`LocationID`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `AddressProvince` FOREIGN KEY (`AddressProvinceID`) REFERENCES `province` (`ProvinceID`),
  ADD CONSTRAINT `PersonType` FOREIGN KEY (`PersonTypeID`) REFERENCES `persontype` (`PersonTypeID`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `ScheduleDay` FOREIGN KEY (`ScheduleDayID`) REFERENCES `scheduleday` (`ScheduleDayID`),
  ADD CONSTRAINT `ScheduleType` FOREIGN KEY (`ScheduleTypeID`) REFERENCES `scheduletype` (`ScheduleTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
