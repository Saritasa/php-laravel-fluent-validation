<?php

namespace Saritasa\Laravel\Validation;

/**
 * Validation rules, applicable only to uploaded files
 */
class FileRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['min', 'max', 'mimetypes', 'mimes'];

    public function __construct(array $rules = [])
    {
        if ($rules) {
            if (!in_array('image', $rules)) {
                $rules = self::mergeIfNotExists('file', $rules);
            }
        } else {
            $rules = ['file'];
        }

        parent::__construct($rules);
    }

    /**
     * @param array|\Closure $constraints
     * @return ImageRuleSet
     */
    public function image($constraints = []): ImageRuleSet
    {
        return new ImageRuleSet($this->rules, $constraints);
    }

    /**
     * The file under validation must match one of the given MIME types
     * To determine the MIME type of the uploaded file, the file's contents will be read and the framework will attempt to guess the MIME type, which may be different from the client provided MIME type.
     *
     * @param \string[] ...$types
     * @return $this|static
     */
    public function mimetypes(string ...$types)
    {
        return $this->appendIfNotExists('mimetypes:'.implode(',', $types));
    }


    /**
     * The file under validation must have a MIME type corresponding to one of the listed extensions.
     * Ex. 'photo' => 'mimes:jpeg,bmp,png'
     *
     * Even though you only need to specify the extensions, this rule actually validates
     * against the MIME type of the file by reading the file's contents and guessing its MIME type.
     *
     * A full listing of MIME types and their corresponding extensions may be found at the following location:
     * https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
     *
     * @param \string[] ...$extensions
     * @return $this|static
     */
    public function mimes(string ...$extensions)
    {
        return $this->appendIfNotExists('mimes:'.implode(',', $extensions));
    }
}
