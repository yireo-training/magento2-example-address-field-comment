<?php
namespace Yireo\ExampleAddressFieldComment\Plugin;

use Magento\Customer\Block\Address\Edit as Subject;
use Yireo\ExampleAddressFieldComment\Block\Address\Edit\Field\Comment as CommentBlock;

/**
 * Class AddCommentFieldToAddressForm
 *
 * @package Yireo\ExampleAddressFieldComment\Plugin
 */
class AddCommentFieldToAddressForm
{
    /**
     * @param Subject $subject
     * @param string $html
     *
     * @return string
     */
    public function afterToHtml(Subject $subject, $html)
    {
        $commentBlock = $this->getChildBlock(CommentBlock::class, $subject);
        $commentBlock->setAddress($subject->getAddress());
        $html = $this->appendBlockBeforeFieldsetEnd($html, $commentBlock->toHtml());

        return $html;
    }

    /**
     * @param string $html
     * @param string $childHtml
     *
     * @return string
     */
    private function appendBlockBeforeFieldsetEnd($html, $childHtml)
    {
        $pregMatch = '/\<\/fieldset\>/';
        $pregReplace = $childHtml . '\0';
        $html = preg_replace($pregMatch, $pregReplace, $html, 1);

        return $html;
    }

    /**
     * @param $parentBlock
     *
     * @return mixed
     */
    private function getChildBlock($blockClass, $parentBlock)
    {
        return $parentBlock->getLayout()->createBlock($blockClass, basename($blockClass));
    }
}