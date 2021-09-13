<?php

namespace WilsonGlasser\Spout\Common\Entity\Style;

/**
 * Class Style
 * Represents a style to be applied to a cell
 */
class Style
{
    /** Default font values */
    const DEFAULT_FONT_SIZE = 11;
    const DEFAULT_FONT_COLOR = Color::BLACK;
    const DEFAULT_FONT_NAME = 'Arial';
    const ALIGN_TOP = 'top';
    const ALIGN_MIDDLE = 'center';
    const ALIGN_DEFAULT = 'general';
    const ALIGN_BOTTOM = 'bottom';
    const ALIGN_LEFT = 'left';
    const ALIGN_RIGHT = 'right';

    /** @var int|null Style ID */
    private $id;

    /** @var bool Whether the font should be bold */
    private $fontBold = false;
    /** @var bool Whether the bold property was set */
    private $hasSetFontBold = false;

    /** @var bool Whether the font should be italic */
    private $fontItalic = false;
    /** @var bool Whether the italic property was set */
    private $hasSetFontItalic = false;

    /** @var bool Whether the font should be underlined */
    private $fontUnderline = false;
    /** @var bool Whether the underline property was set */
    private $hasSetFontUnderline = false;

    /** @var bool Whether the font should be struck through */
    private $fontStrikethrough = false;
    /** @var bool Whether the strikethrough property was set */
    private $hasSetFontStrikethrough = false;

    /** @var int Font size */
    private $fontSize = self::DEFAULT_FONT_SIZE;
    /** @var bool Whether the font size property was set */
    private $hasSetFontSize = false;

    /** @var string Font color */
    private $fontColor = self::DEFAULT_FONT_COLOR;
    /** @var bool Whether the font color property was set */
    private $hasSetFontColor = false;

    /** @var string Font name */
    private $fontName = self::DEFAULT_FONT_NAME;
    /** @var bool Whether the font name property was set */
    private $hasSetFontName = false;

    /** @var bool Whether specific font properties should be applied */
    private $shouldApplyFont = false;

    /** @var bool Whether the text should wrap in the cell (useful for long or multi-lines text) */
    private $shouldWrapText = false;
    /** @var bool Whether the wrap text property was set */
    private $hasSetWrapText = false;

    /** @var bool Text need to shrink to fit */
    private $shrinkToFit = false;

    /** @var string Horizontal align */
    private $horizontalAlign = '';

    /** @var string Vertical align */
    private $verticalAlign = self::ALIGN_MIDDLE;

    /** @var Border */
    private $border;

    /** @var bool Whether border properties should be applied */
    private $shouldApplyBorder = false;

    /** @var string Background color */
    private $backgroundColor;

    /** @var bool */
    private $hasSetBackgroundColor = false;

    /** @var float */
    private $height;

    /** @var NumberFormat */
    private $numberFormat;

    /** @var string Format */
    private $format;

    /** @var bool */
    private $hasSetFormat = false;

    private static $instance;

    public static function defaultStyle() {
        if (self::$instance === null) {
            self::$instance = new Style();
        }
        return self::$instance;
    }

    /**
     * Get row height
     * @return float|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set row height
     * @param float $height
     * @return Style
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Style
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Border
     */
    public function getBorder()
    {
        return $this->border;
    }

    /**
     * @param Border $border
     * @return Style
     */
    public function setBorder(Border $border)
    {
        $this->shouldApplyBorder = true;
        $this->border = $border;

        return $this;
    }

    /**
     * @return bool
     */
    public function shouldApplyBorder()
    {
        return $this->shouldApplyBorder;
    }

    /**
     * @return bool
     */
    public function isFontBold()
    {
        return $this->fontBold;
    }

    /**
     * @return Style
     */
    public function setFontBold()
    {
        $this->fontBold = true;
        $this->hasSetFontBold = true;
        $this->shouldApplyFont = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetFontBold()
    {
        return $this->hasSetFontBold;
    }

    /**
     * @return bool
     */
    public function isFontItalic()
    {
        return $this->fontItalic;
    }

    /**
     * @return Style
     */
    public function setFontItalic()
    {
        $this->fontItalic = true;
        $this->hasSetFontItalic = true;
        $this->shouldApplyFont = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetFontItalic()
    {
        return $this->hasSetFontItalic;
    }

    /**
     * @return bool
     */
    public function isFontUnderline()
    {
        return $this->fontUnderline;
    }

    /**
     * @return Style
     */
    public function setFontUnderline()
    {
        $this->fontUnderline = true;
        $this->hasSetFontUnderline = true;
        $this->shouldApplyFont = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetFontUnderline()
    {
        return $this->hasSetFontUnderline;
    }

    /**
     * @return bool
     */
    public function isFontStrikethrough()
    {
        return $this->fontStrikethrough;
    }

    /**
     * @return Style
     */
    public function setFontStrikethrough()
    {
        $this->fontStrikethrough = true;
        $this->hasSetFontStrikethrough = true;
        $this->shouldApplyFont = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetFontStrikethrough()
    {
        return $this->hasSetFontStrikethrough;
    }

    /**
     * @return int
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * @param int $fontSize Font size, in pixels
     * @return Style
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
        $this->hasSetFontSize = true;
        $this->shouldApplyFont = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetFontSize()
    {
        return $this->hasSetFontSize;
    }

    /**
     * @return string
     */
    public function getFontColor()
    {
        return $this->fontColor;
    }

    /**
     * Sets the font color.
     *
     * @param string $fontColor ARGB color (@see Color)
     * @return Style
     */
    public function setFontColor($fontColor)
    {
        $this->fontColor = $fontColor;
        $this->hasSetFontColor = true;
        $this->shouldApplyFont = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetFontColor()
    {
        return $this->hasSetFontColor;
    }

    /**
     * @return string
     */
    public function getFontName()
    {
        return $this->fontName;
    }

    /**
     * @param string $fontName Name of the font to use
     * @return Style
     */
    public function setFontName($fontName)
    {
        $this->fontName = $fontName;
        $this->hasSetFontName = true;
        $this->shouldApplyFont = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetFontName()
    {
        return $this->hasSetFontName;
    }

    /**
     * @return bool
     */
    public function shouldWrapText()
    {
        return $this->shouldWrapText;
    }

    /**
     * @param bool $shouldWrap Should the text be wrapped
     * @return Style
     */
    public function setShouldWrapText($shouldWrap = true)
    {
        $this->shouldWrapText = $shouldWrap;
        $this->hasSetWrapText = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSetWrapText()
    {
        return $this->hasSetWrapText;
    }

    /**
     * @return bool Whether specific font properties should be applied
     */
    public function shouldApplyFont()
    {
        return $this->shouldApplyFont;
    }

    /**
     * @return string
     */
    public function getVerticalAlign()
    {
        return $this->verticalAlign;
    }

    /**
     * @param string $verticalAlign Set text vertical align
     * @return Style
     */
    public function setVerticalAlign($verticalAlign )
    {
        $this->verticalAlign = $verticalAlign;

        return $this;
    }

    /**
     * @return string
     */
    public function getHorizontalAlign()
    {
        return $this->horizontalAlign;
    }

    /**
     * @param string $verticalAlign Set text vertical align
     * @return Style
     */
    public function setHorizontalAlign($horizontalAlign )
    {
        $this->horizontalAlign = $horizontalAlign;

        return $this;
    }
    /**
     * Sets shrink to fit
     * @param bool
     * @return Style
     */
    public function setShrinkToFit($shouldShrink=false)
    {
        $this->shrinkToFit = $shouldShrink;

        return $this;
    }

    /**
     * @return bool
     */
    public function getShrinkToFit()
    {
        return $this->shrinkToFit;
    }

    /**
     * Sets the background color
     * @param string $color ARGB color (@see Color)
     * @return Style
     */
    public function setBackgroundColor($color)
    {
        $this->hasSetBackgroundColor = true;
        $this->backgroundColor = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @return bool Whether the background color should be applied
     */
    public function shouldApplyBackgroundColor()
    {
        return $this->hasSetBackgroundColor;
    }

    /**
     * Sets format
     * @param string $format
     * @return Style
     */
    public function setFormat($format)
    {
        $this->hasSetFormat = true;
        $this->format = $format;
        $this->isEmpty = false;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return bool Whether format should be applied
     */
    public function shouldApplyFormat()
    {
        return $this->hasSetFormat;
    }

    /**
     * @return bool
     */
    public function isRegistered() : bool
    {
        return $this->isRegistered;
    }

    public function markAsRegistered(?int $id) : void
    {
        $this->setId($id);
        $this->isRegistered = true;
    }

    public function unmarkAsRegistered() : void
    {
        $this->setId(0);
        $this->isRegistered = false;
    }

    public function isEmpty() : bool
    {
        return $this->isEmpty;
    }

    /**
     * @return NumberFormat
     */
    public function getNumberFormat()
    {
        return $this->numberFormat;
    }

    /**
     * Sets the number format.
     *
     * @param NumberFormat $numberFormat
     * @return Style
     */
    public function setNumberFormat($numberFormat)
    {
        $this->numberFormat = $numberFormat;

        return $this;
    }
}
