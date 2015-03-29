<?php namespace Anomaly\EditorFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class EditorFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\EditorFieldType
 */
class EditorFieldType extends FieldType
{

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.editor::input';

    /**
     * The field type config.
     *
     * @var array
     */
    protected $config = [
        'theme'  => 'chrome',
        'mode'   => 'html',
        'height' => 500
    ];

    /**
     * The application utility.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new EditorFieldType instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the storage path.
     *
     * @return null|string
     */
    public function getStoragePath()
    {

        // If it's manually set just return it.
        if ($path = $this->configGet('path')) {
            return $path;
        }

        // No entry, no path.
        if (!$this->entry) {
            return null;
        }

        // If the entry is not an EntryInterface skip it.
        if (!$this->entry instanceof EntryInterface) {
            return null;
        }

        $slug      = $this->entry->getStreamSlug();
        $namespace = $this->entry->getStreamNamespace();
        $folder    = str_slug($this->entry->getTitle(), '_');
        $file      = $this->getField() . '.' . array_get($this->getConfig(), 'mode');

        return $this->application->getStoragePath("{$namespace}/{$slug}/{$folder}/{$file}");
    }
}
