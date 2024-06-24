<?php

namespace App\Tests\Entity;

use App\Entity\Event;
use DateTime;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testEventEntity()
    {
        $event = new Event();

        $title = "Coffee Tasting";
        $event->setTitle($title);
        $this->assertEquals($title, $event->getTitle());

        $datetime = new DateTime('2024-12-01 10:00:00');
        $event->setDatetime($datetime);
        $this->assertEquals($datetime, $event->getDatetime());

        $description = "A special event for tasting various types of coffee.";
        $event->setDescription($description);
        $this->assertEquals($description, $event->getDescription());

        $imageFilename = "coffee_tasting.jpg";
        $event->setImageFilename($imageFilename);
        $this->assertEquals($imageFilename, $event->getImageFilename());

        $createdAt = new DateTime();
        $event->setCreatedAtValue();
        $this->assertInstanceOf(DateTime::class, $event->getCreatedAt());

        $updatedAt = new DateTime();
        $event->setUpdatedAtValue();
        $this->assertInstanceOf(DateTime::class, $event->getUpdatedAt());
    }
}
