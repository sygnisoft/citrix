<?php
namespace Citrix;

use Citrix\Authentication\Authentication;
use Citrix\Entity\Webinar;
use Citrix\Entity\Consumer;

/**
 * Use this to get/post data from/to Citrix.
 *
 * @uses \Citrix\ServiceAbstract
 * @uses \Citrix\CitrixApiAware
 */
class GoToWebinar extends ServiceAbstract implements CitrixApiAware
{

  /**
   * Authentication Client
   *
   * @var Citrix
   */
  private $client;

  /**
   * Begin here by passing an authentication class.
   *
   * @param $client - authentication client
   */
  public function __construct($client)
  {
      $this->setClient($client);
  }

  /**
   * Get upcoming webinars.
   *
   * @return \ArrayObject - Processed response
   */
  public function getUpcoming()
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/upcomingWebinars';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();
    
      return $this->getResponse();
  }

    /**
     * Get all webinars.
     *
     * @return \ArrayObject - Processed response
    */
    public function getWebinars()
    {
        $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars';
        $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();

        return $this->getResponse();
    }

  /**
   * Get past webinars.
   *
   * @deprecated - Use GoToWebinar::getPast() instead2
   * @return \ArrayObject - Processed response
   */
  public function getPastWebinars($since,$until)
  {
      return $this->getPast($since,$until);
  }

  /**
   * Get all past webinars.
   * @todo - add date range
   * @return \ArrayObject - Processed response
   */
  public function getPast($since,$until)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/historicalWebinars';
      $this->setHttpMethod('GET')
        ->setParams(array('fromTime' => $since, 'toTime' => $until))
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();

      return $this->getResponse();
  }

  /**
   * Get info for a single webinar by passing the webinar id or
   * in Citrix's terms webinarKey.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Webinar
   */
  public function getWebinar($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey;
      $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);
      return $this->getResponse();
  }
  /**
   * ADDED by jwilson on 2015-12-01
   */
  public function createWebinar($params)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars';
      $this->setHttpMethod('POST')
          ->setUrl($url)
          ->setParams($params)
          ->sendRequest($this->getClient()->getAccessToken());
      return $this->getResponse();
  }

  /**
   * Update webinar
   */
  public function updateWebinar($webinarKey, $params)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey;
      $this->setHttpMethod('PUT')
          ->setUrl($url)
          ->setParams($params)
          ->sendRequest($this->getClient()->getAccessToken());
      return $this->getResponse();
  }

  /**
   * Cancel webinar
   */
  public function cancelWebinar($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey;
      $this->setHttpMethod('DELETE')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken());
      return $this->getResponse();
  }
    
  /**
   * Get all registrants for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
  public function getRegistrants($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';
      $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();
    
      return $this->getResponse();
  }

  /**
   * Get a single registrant for a given webinar.
   *
   * @param int $webinarKey
   * @param int $registrantKey
   * @return \Citrix\Entity\Consumer
   */
  public function getRegistrant($webinarKey, $registrantKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants/'.$registrantKey;
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }
  
  /**
   * Get all attendees for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
  public function getAttendees($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/attendees';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();

      return $this->getResponse();
  }

  /**
   * Get single attendee.
   *
   * @param int $webinarKey
   * @param int $attendeeKey
   * @return \Citrix\Entity\Consumer
   */
  public function getAttendee($webinarKey, $sessionKey, $attendeeKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/attendees/' . $attendeeKey;
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Get attendee polls.
   *
   * @param int $webinarKey
   * @param int $attendeeKey
   * @return \Citrix\Entity\Consumer
   */
  public function getAttendeePolls($webinarKey, $sessionKey, $attendeeKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/attendees/' . $attendeeKey . '/polls';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Get attendee surveys.
   *
   * @param int $webinarKey
   * @param int $attendeeKey
   * @return \Citrix\Entity\Consumer
   */
  public function getAttendeeSurveys($webinarKey, $sessionKey, $attendeeKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/attendees/' . $attendeeKey . '/surveys';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Get attendee questions.
   *
   * @param int $webinarKey
   * @param int $attendeeKey
   * @return \Citrix\Entity\Consumer
   */
  public function getAttendeeQuestions($webinarKey, $sessionKey, $attendeeKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/attendees/' . $attendeeKey . '/questions';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Get all panelists for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
  public function getPanelists($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/panelists';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Create panelist
   */
  public function createPanelist($webinarKey, $params)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/panelists';
      // print_r($params);
      $this->setHttpMethod('POST')
          ->setUrl($url)
          ->setParams($params)
          ->sendRequest($this->getClient()->getAccessToken());
        return $this->getResponse();
  }

  /**
   * Resend panelist invitation
   */
  public function resendPanelistInvitation($webinarKey, $panelistKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/panelists/' . $panelistKey . '/resendInvitation';
      $this->setHttpMethod('POST')
          ->setUrl($url)
          ->sendRequest($this->getClient()->getAccessToken());
        return $this->getResponse();
  }

  /**
   * Delete panelist
   */
  public function deletePanelist($webinarKey, $panelistKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/panelists/' . $panelistKey;
      $this->setHttpMethod('DELETE')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken());
      return $this->getResponse();
  }
  
  /**
   * Register user for a webinar
   *
   * @param int $webinarKey
   * @param array $registrantData - email, firstName, lastName (required)
   * @return \Citrix\GoToWebinar
   */
  public function register($webinarKey, $registrantData)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';
      $this->setHttpMethod('POST')
        ->setUrl($url)
        ->setParams($registrantData)
        ->sendRequest($this->getClient()->getAccessToken());
        //->processResponse(true);

    return $this->getResponse();
  }
  
  /**
   * Register user for a webinar
   *
   * @param int $webinarKey
   * @param int $registrantKey
   * @return
   */
  public function unregister($webinarKey, $registrantKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants/' . $registrantKey;
      $this->setHttpMethod('DELETE')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();

      return $this->getResponse();
  }

  /**
   * Get all meeting times.
   *
   * @param int $webinarKey
   */
  public function getMeetingTimes($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/meetingtimes';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Gets performance details for all sessions of a specific webinar.
   *
   * @param int $webinarKey
   */
  public function getPerformances($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/performance';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Get all sessions for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
  public function getSessions($webinarKey)
  {
      $params = array(
      'fromTime' => '2017-01-13T10:00:00Z',
      'toTime' => '2017-12-13T10:00:00Z',
    );

      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions';
      $this->setHttpMethod('GET')
        ->setUrl($url)
        ->setParams($params)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Get sessnio performance for a given webinar.
   *
   * @param int $webinarKey
   * @param int $sessionKey
   * @return \Citrix\Entity\Consumer
   */
    public function getSessionPerformance($webinarKey, $sessionKey)
    {
        $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/performance';
        $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

        return $this->getResponse();
    }

  /**
   * Get session attendees for a given webinar and session.
   *
   * @param int $webinarKey
   * @param int $sessionKey
   * @return \Citrix\Entity\Consumer
   */
    public function getSessionAttendees($webinarKey, $sessionKey)
    {
        $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/attendees';
        $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

        return $this->getResponse();
    }

  /**
   * Get all polls for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
    public function getPolls($webinarKey, $sessionKey)
    {
        $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/polls';
        $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

        return $this->getResponse();
    }

    /**
   * Get all surveys for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
    public function getSurveys($webinarKey, $sessionKey)
    {
        $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/surveys';
        $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

        return $this->getResponse();
    }

  /**
   * Get all questions for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
    public function getQuestions($webinarKey, $sessionKey)
    {
        $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/questions';
        $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

        return $this->getResponse();
    }

  /**
   * Get performance for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
    public function getPerformance($webinarKey, $sessionKey)
    {
        $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/sessions/' . $sessionKey . '/performance';
        $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

        return $this->getResponse();
    }


  /**
   * Get info for a single webinar by passing the webinar id or
   * in Citrix's terms webinarKey.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Webinar
   */
  public function getCoorganizers($webinarKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey.'/coorganizers';
      $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

      return $this->getResponse();
  }

  /**
   * Create co-organizer
   */
  public function createCoorganizer($webinarKey, $params)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/coorganizers';
      $this->setHttpMethod('POST')
          ->setUrl($url)
          ->setParams($params)
          ->sendRequest($this->getClient()->getAccessToken());
        return $this->getResponse();
  }

  /**
   * Resend coorganizer invitation
   */
  public function resendCoorganizerInvitation($webinarKey, $coorganizerKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/coorganizers/' . $coorganizerKey . '/resendInvitation';
      $this->setHttpMethod('POST')
          ->setUrl($url)
          ->sendRequest($this->getClient()->getAccessToken());
        return $this->getResponse();
  }

  /**
   * Delete coorganizer
   */
  public function deleteCoorganizer($webinarKey, $coorganizerKey)
  {
      $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/coorganizers/' . $coorganizerKey;
      $this->setHttpMethod('DELETE')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken());
      return $this->getResponse();
  }


  /**
   *
   * @return the $client
   */
  private function getClient()
  {
      return $this->client;
  }

  /**
   *
   * @param Citrix $client
   */
  private function setClient($client)
  {
      $this->client = $client;
    
      return $this;
  }
  
  /* (non-PHPdoc)
   * @see \Citrix\CitrixApiAware::processResponse()
   */
  /**
   * @param bool $single    If we expect a single entity from the server, make this true.
   *                        Single webinar request wasn't working because it was looping its properties.
   */
  public function processResponse($single = false)
  {
      $response = $this->getResponse();
      $this->reset();

      if (isset($response['int_err_code'])) {
          $this->addError($response['msg']);
      }
    
      if (isset($response['description'])) {
          $this->addError($response['description']);
      }

      if ($single === true) {
          if (isset($response['webinarKey'])) {
              $webinar = new Webinar($this->getClient());
              $webinar->setData($response)->populate();
              $this->setResponse($webinar);
          }

          if (isset($response['registrantKey'])) {
              $webinar = new Consumer($this->getClient());
              $webinar->setData($response)->populate();
              $this->setResponse($webinar);
          }
      } else {
          $collection = new \ArrayObject(array());

          foreach ($response as $entity) {
              if (isset($entity['webinarKey'])) {
                  $webinar = new Webinar($this->getClient());
                  $webinar->setData($entity)->populate();
                  $collection->append($webinar);
              }

              if (isset($entity['registrantKey'])) {
                  $webinar = new Consumer($this->getClient());
                  $webinar->setData($entity)->populate();
                  $collection->append($webinar);
              }
          }

          $this->setResponse($collection);
      }
  }
}
