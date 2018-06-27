<?php
namespace CPSIT\T3eventsCourse\Tests\Unit\Domain\Model;
use CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class ScheduleDemandTest extends UnitTestCase {

    /**
     * @var ScheduleDemand
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getMockBuilder(ScheduleDemand::class)->setMethods(['dummy'])->getMock();
    }

    /**
     * @test
     */
    public function deadLineBeforeInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getDeadlineBefore()
        );
    }

    /**
     * @test
     */
    public function deadLineBeforeCanBeSet()
    {
        $date = new \DateTime();
        $this->subject->setDeadlineBefore($date);

        $this->assertSame(
            $date,
            $this->subject->getDeadlineBefore()
        );
    }

    /**
     * @test
     */
    public function deadLineAfterInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getDeadlineAfter()
        );
    }

    /**
     * @test
     */
    public function deadLineAfterCanBeSet()
    {
        $date = new \DateTime();
        $this->subject->setDeadlineAfter($date);

        $this->assertSame(
            $date,
            $this->subject->getDeadlineAfter()
        );
    }
}
