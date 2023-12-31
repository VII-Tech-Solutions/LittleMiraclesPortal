<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\StudioCategory;
use App\Models\StudioMetadata;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class StudioMetadataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->albumSize();
        $this->spreads();
        $this->paperType();
        $this->coverType();
        $this->canvasThickness();
        $this->canvasSize();
        $this->paperSize();
    }
    function createImage($width,$height)
    {

        $unselected_background = Image::canvas(500, 500, '#d0d3d6');
        $img = Image::make($unselected_background)->resize($width*10, $height*10);
        return $img->encode('data-url') ?? null;

    }

    function albumSize(){
        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "5x7",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(5,7),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "6x6",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(6,6),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "8x8",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(8,8),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "8x10",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(8,10),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "8x12",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(8,12),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "9x12",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(9,12),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "10x10",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(10,10),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
        Attributes::TITLE => "12x12",
        Attributes::DESCRIPTION => null,
        Attributes::IMAGE => $this->createImage(12,12),
        Attributes::CATEGORY => StudioCategory::ALBUM_SIZE,
        Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

    }

    function spreads(){
        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "5",
            Attributes::DESCRIPTION => "(10 pages)",
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::SPREADS,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "10",
            Attributes::DESCRIPTION => "(20 pages)",
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::SPREADS,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "15",
            Attributes::DESCRIPTION => "(30 pages)",
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::SPREADS,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "20",
            Attributes::DESCRIPTION => "(40 pages)",
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::SPREADS,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "25",
            Attributes::DESCRIPTION => "(50 pages)",
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::SPREADS,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);
    }

    function paperType(){
        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Photo Lustre",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Premium Lustre",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Smooth Matte",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Photo Deep Matte",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Lustre/Glossy",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Mettalic",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Deep Matte",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);
    }

    function coverType(){
        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Elegant Linen",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::COVER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Scrapbook",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::COVER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Textured Fabric",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::COVER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Vintage Leather",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::COVER_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);
    }

    function canvasThickness(){
        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "2 cm Thickness",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::CANVAS_THICKNESS,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "4 cm Thickness",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::CANVAS_THICKNESS,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);
    }

    function canvasSize(){
        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "4x6",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(5,7),
            Attributes::CATEGORY => StudioCategory::CANVAS_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "5x7",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(5,7),
            Attributes::CATEGORY => StudioCategory::CANVAS_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "8x10",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(8,10),
            Attributes::CATEGORY => StudioCategory::CANVAS_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "9x16",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(9,16),
            Attributes::CATEGORY => StudioCategory::CANVAS_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "11x14",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(11,14),
            Attributes::CATEGORY => StudioCategory::CANVAS_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "11x16",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(11,16),
            Attributes::CATEGORY => StudioCategory::CANVAS_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "12x16",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(12,16),
            Attributes::CATEGORY => StudioCategory::CANVAS_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);
    }

    function paperSize(){
        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Year book",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "8 up wallet (2.5x3.5)",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "56 wallet special",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Mini snapshot",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "3.5x5",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(3.5,5),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "4x5",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(4,5),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "4x6",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(4,6),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "5x5",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(5,5),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "5x7",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(5,7),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "8x8",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(8,8),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "4x10",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(4,10),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "5x10",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(5,10),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "7x10",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(7,10),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "8x10",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(8,10),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "8x12",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(8,12),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "9x12",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(9,12),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "10x10",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(10,10),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "10x13",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(10,13),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "10x15",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(10,15),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "10x20",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(10,20),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "5x30",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(5,30),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "10x30",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(10,30),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "11x14",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(11,14),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "11x16",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(11,16),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "12x12",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(12,12),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "12x18",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(12,18),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "12x24",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(12,24),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "15x30",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(15,30),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "16x16",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(16,16),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "16x20",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(16,20),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "16x24",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(16,24),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "20x20",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(20,20),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "20x24",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(20,24),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "20x30",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(20,30),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "20x40",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(20,40),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "24x30",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(24,30),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "24x36",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(24,36),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "30x30",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(30,30),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "30x40",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(30,40),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "30x45",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => $this->createImage(30,45),
            Attributes::CATEGORY => StudioCategory::PAPER_SIZE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);
    }

    function printType(){
        StudioMetadata::createOrUpdate([
            Attributes::TITLE => "Fine Art Prints",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PRINT_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);

        StudioMetadata::createOrUpdate([

            Attributes::TITLE => "Photographic Prints",
            Attributes::DESCRIPTION => null,
            Attributes::IMAGE => null,
            Attributes::CATEGORY => StudioCategory::PRINT_TYPE,
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY
        ]);
    }
}
