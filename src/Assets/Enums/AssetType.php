<?php
namespace GooberBlox\Assets\Enums;
/*
    some are missing (couldnt find documented anywhere online and i cant even find in the 2019 src (im blind))
    missing ones: 14,15,20,23,36
      - dawn 6/18/24
*/
enum AssetType : int
{
    case Image	= 1;
    case TShirt = 2;
    case Audio = 3;
    case Mesh = 4;
    case Lua = 5;
    case HTML = 6;
    case Text = 7;
    case Hat = 8;
    case Place = 9;
    case Model	= 10;
    case Shirt	= 11;
    case Pants	= 12;
    case Decal	= 13;
    case Avatar = 16;
    case Head = 17;
    case Face = 18;
    case Gear = 19;
    case Badge	= 21;
    case GroupEmblem = 22;
    case Animation = 24;
    case Arms = 25;
    case Legs = 26;
    case Torso	= 27;
    case RightArm = 28;
    case LeftArm = 29;
    case LeftLeg = 30;
    case RightLeg = 31;
    case Package = 32;
    case YouTubeVideo = 33;
    case GamePass = 34;
    case App = 35;
    case Code = 37;
    case Plugin = 38;
    case SolidModel = 39;
    case MeshPart = 40;
    case HairAccessory = 41;
    case FaceAccessory = 42;
    case NeckAccessory = 43;
    case ShoulderAccessory = 44;
    case FrontAccessory = 45;
    case BackAccessory	= 46;
    case WaistAccessory = 47;
    case ClimbAnimation = 48;
    case DeathAnimation = 49;
    case FallAnimation	= 50;
    case IdleAnimation	= 51;
    case JumpAnimation	= 52;
    case RunAnimation	= 53;
    case SwimAnimation	= 54;
    case WalkAnimation	= 55;
    case PoseAnimation	= 56;
    case EarAccessory = 57; // not used in 2019 src - dawn 6/18/24
    case EyeAccessory = 58; // not used in 2019 src - dawn 6/18/24
    case LocalizationTableManifest = 59;
    case LocalizationTableTranslation = 60;
    case EmoteAnimation = 61;
    case Video = 62;
    case TexturePack = 63;
    // the following are newer than the 2019 src leak and shouldnt be needed unless we rebrand and become RBLX24 or some shit - dawn 6/18/24
    case TShirtAccessory = 64;
	case ShirtAccessory = 65;
	case PantsAccessory = 66;
	case JacketAccessory = 67;
	case SweaterAccessory = 68;
	case ShortsAccessory = 69;
	case LeftShoeAccessory = 70;
	case RightShoeAccessory = 71;
	case DressSkirtAccessory = 72;
	case FontFamily = 73;
	case FontFace = 74;
	case MeshHiddenSurfaceRemoval = 75;
	case EyebrowAccessory = 76;
	case EyelashAccessory = 77;
	case MoodAnimation = 78;
	case DynamicHead = 79;
	case CodeSnippet = 80;
}