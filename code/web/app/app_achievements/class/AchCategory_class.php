<?php
	/*
	 * Category class that is loading all achievements tied to it.
	 */

	class AchCategory extends AchList implements Tieable {
		protected $ties_cult;
		protected $ties_civ;
		protected $ties_race;
		protected $ties_race_dev;
		protected $ties_cult_dev;
		protected $ties_civ_dev;
		protected $cult;
		protected $civ;
		protected $race;
		protected $heroic;
		protected $contest;

		function AchCategory($id,$race = null,$cult = null,$civ = null) {
			global $DBc,$_USER;

			parent::__construct();

			$civ = $DBc->sqlEscape($civ);
			$cult = $DBc->sqlEscape($cult);
			$race = $DBc->sqlEscape($race);

			if($race == null) {
				$race = $_USER->getRace();
			}

			if($cult == null) {
				$cult = $_USER->getCult();
			}

			if($civ == null) {
				$civ = $_USER->getCiv();
			}

			$this->cult = $cult;
			$this->civ = $civ;

			$this->id = $DBc->sqlEscape($id);

			$res = $DBc->sqlQuery("SELECT * FROM ach_achievement LEFT JOIN (ach_achievement_lang) ON (aal_lang='".$_USER->getLang()."' AND aal_achievement=aa_id) WHERE aa_category='".$this->id."' ORDER by aa_sticky DESC, aal_name ASC");

			$sz = sizeof($res);
			for($i=0;$i<$sz;$i++) {
				$tmp = $this->makeChild($res[$i]);
				
				if($tmp->hasOpen()) {
					$this->addOpen($tmp); #AchList::addOpen()
				}
				if($tmp->hasDone()) {
					$this->addDone($tmp); #AchList::addDone()
				}
			}

			$res = $DBc->sqlQuery("SELECT ac_heroic,ac_contest FROM ach_category WHERE ac_id='".$this->id."'");
			$this->heroic = $res[0]['ac_heroic'];
			$this->contest = $res[0]['ac_contest'];
			
			//load counts for tie determination
			/*$res = $DBc->sqlQuery("SELECT count(*) as anz FROM ach_achievement WHERE aa_tie_cult IS NOT NULL AND aa_category='".$this->id."' AND aa_dev='0'");
			$this->ties_cult = $res[0]['anz'];

			$res = $DBc->sqlQuery("SELECT count(*) as anz FROM ach_achievement WHERE aa_tie_civ IS NOT NULL AND aa_category='".$this->id."' AND aa_dev='0'");
			$this->ties_civ = $res[0]['anz'];

			$res = $DBc->sqlQuery("SELECT count(*) as anz FROM ach_achievement WHERE aa_tie_race IS NOT NULL AND aa_category='".$this->id."' AND aa_dev='0'");
			$this->ties_race = $res[0]['anz'];

			$res = $DBc->sqlQuery("SELECT count(*) as anz FROM ach_achievement WHERE aa_tie_race IS NOT NULL AND aa_category='".$this->id."'");
			$this->ties_race_dev = $res[0]['anz'];

			$res = $DBc->sqlQuery("SELECT count(*) as anz FROM ach_achievement WHERE aa_tie_cult IS NOT NULL AND aa_category='".$this->id."'");
			$this->ties_cult_dev = $res[0]['anz'];

			$res = $DBc->sqlQuery("SELECT count(*) as anz FROM ach_achievement WHERE aa_tie_civ IS NOT NULL AND aa_category='".$this->id."'");
			$this->ties_civ_dev = $res[0]['anz'];*/

			$iter = $this->nodes->getIterator();
			$tmp = false;
			while($iter->hasNext()) {
				$curr = $iter->getNext();
				if($curr->getTieRace()) {
					$tmp = true;
					break;
				}
			}
			$this->ties_race = $tmp;

			$iter = $this->nodes->getIterator();
			$tmp = false;
			while($iter->hasNext()) {
				$curr = $iter->getNext();
				if($curr->getTieCiv()) {
					$tmp = true;
					break;
				}
			}
			$this->ties_civ = $tmp;

			$iter = $this->nodes->getIterator();
			$tmp = false;
			while($iter->hasNext()) {
				$curr = $iter->getNext();
				if($curr->getTieCult()) {
					$tmp = true;
					break;
				}
			}
			$this->ties_cult = $tmp;
		}
		
		#@override Parentum::makeChild()
		protected function makeChild($a) {
			return new AchAchievement($a,$this);
		}

		function isTiedRace() {
			return ($this->ties_race > 0);
		}

		function isTiedCult() {
			return ($this->ties_cult > 0);
		}

		function isTiedCiv() {
			return ($this->ties_civ > 0);
		}

		function isTiedRaceDev() {
			return ($this->ties_race_dev > 0);
		}

		function isTiedCultDev() {
			return ($this->ties_cult_dev > 0);
		}

		function isTiedCivDev() {
			return ($this->ties_civ_dev > 0);
		}

		function getCurrentCiv() {
			return $this->civ;
		}

		function getCurrentCult() {
			return $this->cult;
		}

		function getCurrentRace() {
			return $this->race;
		}

		function isHeroic() {
			return ($this->heroic == 1);
		}

		function isContest() {
			return ($this->contest == 1);
		}
	}
?>