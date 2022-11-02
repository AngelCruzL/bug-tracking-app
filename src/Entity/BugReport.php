<?php

  namespace App\Entity;

  class BugReport extends Entity
  {

    private $id;
    private $report_type;
    private $message;
    private $link;
    private $email;
    private $created_at;

    public function toArray(): array
    {
      return [
        'report_type' => $this->getReportType(),
        'message' => $this->getMessage(),
        'link' => $this->getLink(),
        'email' => $this->getEmail(),
        'created_at' => date('Y-m-d H:i:s')
      ];
    }
    
    public function getId(): int
    {
      return $this->id;
    }

    /**
     * @return mixed
     */
    public function getReportType(): string
    {
      return $this->report_type;
    }

    /**
     * @param string $report_type
     * @return BugReport
     */
    public function setReportType(string $report_type)
    {
      $this->report_type = $report_type;
      return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return BugReport
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
      return $this->link;
    }

    /**
     * @param string|null $link
     * @return BugReport
     */
    public function setLink(?string $link)
    {
      $this->link = $link;
      return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
      return $this->email;
    }

    /**
     * @param string $email
     * @return BugReport
     */
    public function setEmail(string $email)
    {
      $this->email = $email;
      return $this;
    }

    public function getCreatedAt()
    {
      return $this->created_at;
    }
  }