<?php
namespace CPSIT\T3eventsCourse\Tests\Unit\Domain\Model;

use CPSIT\T3eventsCourse\Domain\Model\Certificate;
use CPSIT\T3eventsCourse\Domain\Model\CertificateType;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Dirk Wenzel <dirk.wenzel@cps-it.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class CertificateTest
 *
 * @package CPSIT\T3eventsCourse\Tests\Unit\Domain\Model
 * @coversDefaultClass \CPSIT\T3eventsCourse\Domain\Model\Certificate
 */
class CertificateTest extends UnitTestCase {

	/**
	 * @var \CPSIT\T3eventsCourse\Domain\Model\Certificate
	 */
	protected $subject;

	/**
	 * set up
	 */
	public function setUp() {
		$this->subject = $this->getAccessibleMock(
			Certificate::class,
			['dummy']
		);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$title = 'foo';
		$this->subject->setTitle($title);

		$this->assertSame(
			$title,
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() {
		$description = 'foo';
		$this->subject->setDescription($description);

		$this->assertSame(
			$description,
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function getTypeReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getType()
		);
	}

	/**
	 * @test
	 */
	public function setTypeForObjectSetsType() {
		$type = new CertificateType();
		$this->subject->setType($type);

		$this->assertSame(
			$type,
			$this->subject->getType()
		);
	}
	
	/**
     * @test
     */
	public function getShortPas1045InitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getShortPas1045()
        );
    }
    
    /**
     * @test
     */
    public function shortPas1045CanBeSet()
    {
        $text = 'foo';
        $this->subject->setShortPas1045($text);
        $this->assertSame(
            $text,
            $this->subject->getShortPas1045()
        );
    }

    /**
     * @test
     */
    public function getShortQcatInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getShortQcat()
        );
    }

    /**
     * @test
     */
    public function shortQcatCanBeSet()
    {
        $text = 'foo';
        $this->subject->setShortQcat($text);
        $this->assertSame(
            $text,
            $this->subject->getShortQcat()
        );
    }

    /**
     * @test
     */
    public function getLinkInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getLink()
        );
    }

    /**
     * @test
     */
    public function linkCanBeSet()
    {
        $text = 'foo';
        $this->subject->setLink($text);
        $this->assertSame(
            $text,
            $this->subject->getLink()
        );
    }
}
