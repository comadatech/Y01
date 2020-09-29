/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  comad
 * Created: Aug. 31, 2020
 */

use Y01;

ALTER TABLE activityregistration DROP INDEX ActivityRegActivity;

ALTER TABLE activityregistration CHANGE ActivityID ActivityScheduleID INT;

DROP PROCEDURE USP_GetActivityScheduleList;

CREATE DEFINER=`root`@`localhost` PROCEDURE `y01`.`USP_GetActivityScheduleList`(IN `PersonID` INT, IN `language` CHAR(3))
BEGIN

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

from activityschedule
	left join activity
	on activityschedule.ActivityID = activity.ActivityID
    
		left join activityregistration
		on activityschedule.ActivityScheduleID = activityregistration.ActivityScheduleID
		and activityregistration.PersonID = PersonID

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

END

drop procedure 	USP_GetPersonScedule;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GetPersonSchedule`(IN `PersonID` INT, IN `language` CHAR(3))
BEGIN

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
            on activityregistration.ActivityScheduleID = activityschedule.ActivityScheduleID
            
				join activity
                on activityschedule.ActivityID = activity.ActivityID
                
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
DELIMITER ;

ALTER TABLE `y01`.`activityregistration` DROP INDEX `ActivitySchedule`, ADD INDEX `ActivitySchedule` (`ActivityScheduleID`) USING BTREE;

DROP PROCEDURE USP_GetUserSubscription;
