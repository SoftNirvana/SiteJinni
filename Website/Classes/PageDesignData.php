<?php
class DesignParts {
	public $PartName = null;
	public function __construct($name) {
		$this->PartName = $name;
	}
}

class PageDesignHeaderData extends DesignParts {
    public $Header = "My Website";
    public $Address1 = "House Number, Street Name";
    public $Address2 = "City Name, Zipcode, State";
    public $Phonenum = "+91 879 093219";
    public $CompanyName = "Some Company";

}
class MainImages extends DesignParts {
	
	public $images = null;
	
	public function addImage($imagePath) {

		array_push($this->images, $imagePath);
	}
}

class PageDesignAmenity extends DesignParts {
	public $AmenityName;
	public $imagePath;
	public $AmenityDescription;
	public $iconclass;
}

class PageDesignAmenities extends DesignParts {
	public $Amenities;

	public function addAmenity($amenity) {

		array_push($this->Amenities, $amenity);
	}
}

class PageDesignDocument extends DesignParts {
	public $DocumentName;
	public $DocumentPath;
	public $DocumentDescription;
}

class PageDesignDocuments extends DesignParts {
	public $Documents;
	
	public function addDocument($documentUp) {

		array_push($this->Documents, $documentUp);
	}
}

class PageDesignMapLocation extends DesignParts {
	public $LocationName;
	public $LocationDesc;
	public $LocationLat;
	public $LocationLng;
}

class PageDesignAbout extends DesignParts {
	public $AboutImagePath;
	public $AboutDescription;
}

class PageDesignTeamMember extends DesignParts {
	public $MemberName;
	public $imagePath;
	public $MemberDesignation;
}

class PageDesignTeamMembers extends DesignParts {
	public $Members;
	
	public function addMember($member) {

		array_push($this->Members, $member);
	}
}
class PageDesignCompanyLocation extends DesignParts {
	public $CompanyAddress;
	public $CompanyNumber;
	public $CompanyEmail;
	public $CompanyLat;
	public $CompanyLng;
}

class PageDesignProject extends DesignParts {
	public $ProjectName;
	public $ProjectURL;
	public $imagePath;
	public $ProjectDescription;
}

class PageDesignProjects extends DesignParts {
	public $Projects;
	
	public function addProject($project) {

		array_push($this->Projects, $project);
	}
}

class ShortDescription extends DesignParts {
	public $description;
	
	
}

class FullPageDesign extends DesignParts {
	public $allParts;
    
}     
   // For Individual or Personel or CVs     
 class PageDesignEducation extends DesignParts {
    public $UniversityName;
    public $Degree;
    public $YearOfPassing;
    public $Info;
}
        
class PageDesignEducations extends DesignParts {
    public $Educations;

    public function addEducation($education) {

            array_push($this->Educations, $education);
    }
}        
 class PageDesignWorkExperience extends DesignParts{
     public $CompanyName;
     public $Designation;
     public $Experience;
     Public $Description;
 }
 class PageDesignWorkExperiences extends DesignParts {
    public $WorkExperiences;

    public function addExperience($WorkExperience) {

            array_push($this->WorkExperiences, $WorkExperience);
    }
}     
 class PageDesignSkill extends DesignParts{
     public $SkillName;
     public $SkillExperience;
 }
 class PageDesignSkills extends DesignParts {
    public $Skills;

    public function addSkill($Skills) {

            array_push($this->Skills, $Skills);
    }
}     
?>