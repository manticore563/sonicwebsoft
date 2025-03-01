<?php

namespace App\Helpers\Classes;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PotraceConverter
{
    protected $inputFile;
    protected $outputFile;
    protected $tempDir;
    protected $binaryPath = 'potrace';
    protected $options = [
        'backend'      => 'svg',      // Output format
        'turdsize'     => 2,          // Ignore areas smaller than this
        'alphamax'     => 1.0,        // Smoothness of curves
        'opttolerance' => 0.2,        // Curve optimization
        'turnpolicy'   => 'minority', // How to resolve ambiguities in path
        'invert'       => false,      // Invert bitmap
        'threshold'    => null,       // Threshold for bitmap conversion
        'fillcolor'    => null,       // Fill color in SVG
        'opaque'       => false,      // Make white shapes opaque
        'group'        => false,      // Group paths in SVG
    ];

    // Mkbitmap-related properties
    protected $useMkbitmap = false;
    protected $mkbitmapPath = 'mkbitmap';
    protected $mkbitmapOptions = [
        'invert'    => false,
        'filter'    => null,
        'blur'      => null,
        'scale'     => null,
        'interpolation' => 'cubic',  // Default is cubic
        'threshold' => null,
        'grey'      => false,
    ];

    // Properties for post-processing
    protected $strokeColor = null;
    protected $strokeWidth = null;

    public function __construct()
    {
        $this->tempDir = sys_get_temp_dir();
    }

    /**
     * Set the input file path.
     */
    public function setTempDir(string $tempDir): self
    {
        $this->tempDir = $tempDir;
        return $this;
    }

    /**
     * Set the input file path.
     */
    public function setInputFile(string $inputFile): self
    {
        $this->inputFile = $inputFile;
        return $this;
    }

    /**
     * Set the output file path.
     */
    public function setOutputFile(string $outputFile): self
    {
        $this->outputFile = $outputFile;
        return $this;
    }

    /**
     * Set the binary path for Potrace.
     */
    public function setBinaryPath(string $binaryPath): self
    {
        $this->binaryPath = $binaryPath;
        return $this;
    }

    // Potrace option setters

    public function setTurdSize(int $turdsize): self
    {
        $this->options['turdsize'] = $turdsize;
        return $this;
    }

    public function setAlphaMax(float $alphamax): self
    {
        $this->options['alphamax'] = $alphamax;
        return $this;
    }

    public function setOptTolerance(float $opttolerance): self
    {
        $this->options['opttolerance'] = $opttolerance;
        return $this;
    }

    public function setTurnPolicy(string $turnpolicy): self
    {
        $validPolicies = ['black', 'white', 'left', 'right', 'minority', 'majority'];
        if (!in_array($turnpolicy, $validPolicies)) {
            throw new \InvalidArgumentException("Invalid turnpolicy. Valid options are: " . implode(', ', $validPolicies));
        }
        $this->options['turnpolicy'] = $turnpolicy;
        return $this;
    }

    public function setInvert(bool $invert): self
    {
        $this->options['invert'] = $invert;
        return $this;
    }

    public function setThreshold(float $threshold): self
    {
        $this->options['threshold'] = $threshold;
        return $this;
    }

    /**
     * Set the fill color for SVG output.
     */
    public function setFillColor(string $color): self
    {
        $this->options['fillcolor'] = $color;
        return $this;
    }

    /**
     * Set whether to make white shapes opaque.
     */
    public function setOpaque(bool $opaque): self
    {
        $this->options['opaque'] = $opaque;
        return $this;
    }

    public function setGroup(bool $group): self
    {
        $this->options['group'] = $group;
        return $this;
    }

    // Mkbitmap option setters

    public function useMkbitmap(bool $use): self
    {
        $this->useMkbitmap = $use;
        return $this;
    }

    public function setMkbitmapPath(?string $path): self
    {
        $this->mkbitmapPath = $path;
        return $this;
    }

    public function setMkbitmapInvert(bool $invert): self
    {
        $this->mkbitmapOptions['invert'] = $invert;
        return $this;
    }

    public function setMkbitmapFilter(int $radius): self
    {
        $this->mkbitmapOptions['filter'] = $radius;
        return $this;
    }

    public function setMkbitmapBlur(int $radius): self
    {
        $this->mkbitmapOptions['blur'] = $radius;
        return $this;
    }

    public function setMkbitmapScale(int $scale): self
    {
        $this->mkbitmapOptions['scale'] = $scale;
        return $this;
    }

    public function setMkbitmapInterpolation(string $interpolation): self
    {
        $validInterpolations = ['linear', 'cubic'];
        if (!in_array($interpolation, $validInterpolations)) {
            throw new \InvalidArgumentException("Invalid interpolation. Valid options are: " . implode(', ', $validInterpolations));
        }
        $this->mkbitmapOptions['interpolation'] = $interpolation;
        return $this;
    }

    public function setMkbitmapThreshold(float $threshold): self
    {
        $this->mkbitmapOptions['threshold'] = $threshold;
        return $this;
    }

    public function setMkbitmapGrey(bool $grey): self
    {
        $this->mkbitmapOptions['grey'] = $grey;
        return $this;
    }

    // Methods for stroke properties (post-processing)

    /**
     * Set the stroke color for SVG output (post-processing).
     */
    public function setStrokeColor(string $color): self
    {
        $this->strokeColor = $color;
        return $this;
    }

    /**
     * Set the stroke width for SVG output (post-processing).
     */
    public function setStrokeWidth(float $width): self
    {
        $this->strokeWidth = $width;
        return $this;
    }

    /**
     * Execute the Potrace command with the specified options.
     */
    public function run()
    {
        if (!$this->inputFile) {
            throw new \Exception("Input file not set.");
        }

        if (!$this->outputFile) {
            throw new \Exception("Output file not set.");
        }

        $inputFile = $this->inputFile;

        // Run mkbitmap if enabled
        if ($this->useMkbitmap) {
            $mkbitmapCommand = [$this->mkbitmapPath];

            // Map mkbitmap options
            foreach ($this->mkbitmapOptions as $key => $value) {
                if ($value === null) {
                    continue;
                }

                switch ($key) {
                    case 'invert':
                        if ($value) {
                            $mkbitmapCommand[] = '-i';
                        }
                        break;

                    case 'filter':
                        $mkbitmapCommand[] = '-f';
                        $mkbitmapCommand[] = $value;
                        break;

                    case 'blur':
                        $mkbitmapCommand[] = '-b';
                        $mkbitmapCommand[] = $value;
                        break;

                    case 'scale':
                        $mkbitmapCommand[] = '-s';
                        $mkbitmapCommand[] = $value;
                        break;

                    case 'interpolation':
                        if ($value === 'linear') {
                            $mkbitmapCommand[] = '-1';
                        } elseif ($value === 'cubic') {
                            $mkbitmapCommand[] = '-3';
                        }
                        break;

                    case 'threshold':
                        $mkbitmapCommand[] = '-t';
                        $mkbitmapCommand[] = $value;
                        break;

                    case 'grey':
                        if ($value) {
                            $mkbitmapCommand[] = '-g';
                        }
                        break;

                    default:
                        break;
                }
            }

            // Specify the input and output files
            $mkbitmapOutput = tempnam($this->tempDir, 'mkbitmap_') . '.pbm';
            $mkbitmapCommand[] = '-o';
            $mkbitmapCommand[] = $mkbitmapOutput;
            $mkbitmapCommand[] = $this->inputFile;

            // Run mkbitmap
            $mkbitmapProcess = new Process($mkbitmapCommand);
            $mkbitmapProcess->run();

            if (!$mkbitmapProcess->isSuccessful()) {
                throw new ProcessFailedException($mkbitmapProcess);
            }

            $inputFile = $mkbitmapOutput; // Use mkbitmap output as input for Potrace
        }

        // Build the Potrace command array
        $command = [$this->binaryPath];

        // Map Potrace options to command-line arguments
        foreach ($this->options as $key => $value) {
            if ($value === null) {
                continue;
            }

            switch ($key) {
                case 'backend':
                    $command[] = '-b';
                    $command[] = $value;
                    break;

                case 'turdsize':
                    $command[] = '-t';
                    $command[] = $value;
                    break;

                case 'alphamax':
                    $command[] = '-a';
                    $command[] = $value;
                    break;

                case 'opttolerance':
                    $command[] = '-O';
                    $command[] = $value;
                    break;

                case 'turnpolicy':
                    $command[] = '-z';
                    $command[] = $value;
                    break;

                case 'invert':
                    if ($value) {
                        $command[] = '-i';
                    }
                    break;

                case 'threshold':
                    $command[] = '-k';
                    $command[] = $value;
                    break;

                case 'fillcolor':
                    $command[] = '--fillcolor';
                    $command[] = $value;
                    break;

                case 'opaque':
                    if ($value) {
                        $command[] = '--opaque';
                    }
                    break;

                case 'group':
                    $command[] = $value ? '--group' : '--flat';
                    break;

                default:
                    break;
            }
        }

        // Specify the output file
        $command[] = '-o';
        $command[] = $this->outputFile;

        // Add the input file
        $command[] = $inputFile;

        // Create and run the Symfony Process
        $process = new Process($command);
        $process->run();

        // Clean up temporary mkbitmap file
        if ($this->useMkbitmap && isset($mkbitmapOutput)) {
            unlink($mkbitmapOutput);
        }

        // Handle errors
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Post-process the SVG to set stroke properties
        $this->postProcessSvg();

        return true;
    }

    /**
     * Post-process the SVG file to set stroke properties.
     */
    protected function postProcessSvg()
    {
        $svgContent = file_get_contents($this->outputFile);

        // Load SVG content into SimpleXMLElement
        $svg = new \SimpleXMLElement($svgContent);

        // Register SVG namespace
        $namespaces = $svg->getNamespaces(true);
        if (isset($namespaces['svg'])) {
            $svg->registerXPathNamespace('svg', $namespaces['svg']);
        } else {
            $svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
        }

        // Use DOM to remove the metadata node
        foreach ($svg->xpath('//svg:metadata') as $metadata) {
            $dom = dom_import_simplexml($metadata);
            $dom->parentNode->removeChild($dom);
        }

        if ($this->strokeWidth !== null || $this->strokeColor !== null) {
            // Iterate over all path elements
            foreach ($svg->xpath('//svg:path') as $path) {
                $attributes = $path->attributes();

                // Set stroke color if specified
                if ($this->strokeColor !== null) {
                    $attributes->stroke = $this->strokeColor;
                }

                // Set stroke width if specified
                if ($this->strokeWidth !== null) {
                    $attributes->{'stroke-width'} = $this->strokeWidth;
                }

                // If stroke is set, ensure fill is set appropriately
                if ($this->strokeColor !== null && !isset($attributes->fill)) {
                    $attributes->fill = 'none';
                }
            }
        }

        // Save the modified SVG content
        $svg->asXML($this->outputFile);
    }
}
