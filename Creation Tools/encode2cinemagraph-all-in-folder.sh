#!/bin/bash
echo "============================================"
echo "==== MEGA CINEMAGRAPH THUMBNAIL CREATOR ===="
echo "============================================"
echo "== creates scaled and cropped videothumbs =="
echo "============================================"

cd "$(dirname "$0")"

# get input file per drag and drop
read -p "Drag input file here: " inputFile

#echo „Datei::$inputFile::“

# remove "" or ''
inputFile=${inputFile%\"}
inputFile=${inputFile#\"}
inputFile=${inputFile%\'}
inputFile=${inputFile#\'}
# remove leading whitespace
inputFile=${inputFile##*( )}
# remove trailing whitespace
inputFile=${inputFile%%*( )}

inputFilename="${inputFile##*/}"
inputName="${inputFilename%.*}"
inputPath="$(dirname "$inputFile")"

tempPath="$inputPath/tmp-output-$(date +%s%3N)"
outputPath="$inputPath/Output"

# create output directory
mkdir "$outputPath"
mkdir "$tempPath"

vScale=600

vBitrate=400

# set average bitrate
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp

echo "======================"
echo "== start encoding.. =="
echo "======================"

#check for os and select the ffmpeg binaries accordingly
if [[ "$OSTYPE" == "msys" ]]; then
  cmdFfmpeg="./bin/win/ffmpeg.exe"
  cmdMp4box="./bin/win/mp4box.exe"
else
  cmdFfmpeg="./bin/mac/ffmpeg"
  cmdMp4box="./bin/mac/MP4Box"
fi

# cd to input path to find all .mp4 files
cd "$inputPath"

# loop through .mp4 files
for f in *.mp4
do
    # dirty.. cd back to script folder
    cd "$(dirname "$0")"

    echo "FILE: $f"
    echo "Encoding video to large and small sizes"

    inputFile="$inputPath/$f"
    # remove "" or ''
    inputFile=${inputFile%\"}
    inputFile=${inputFile#\"}
    inputFile=${inputFile%\'}
    inputFile=${inputFile#\'}
    # remove leading whitespace
    inputFile=${inputFile##*( )}
    # remove trailing whitespace
    inputFile=${inputFile%%*( )}

    #echo "stripped: $inputFile"

    inputFilename="${inputFile##*/}"
    inputName="${inputFilename%.*}"

    # convert to all formats
    $cmdFfmpeg -y -i "$inputFile" -threads 0 -vcodec libvpx -b:v "${vBitrate}k" -maxrate "${vBitrate}k" -bufsize "${vBitrate}k" -vf "scale=-2:$vScale, crop=$vScale:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/${inputName}-thumb.webm" \
      -vcodec libx264 -preset slow -b:v "${vBitrate}k" -maxrate "${vBitrate}k" -bufsize "${vBitrate}k" -vf "scale=-2:$vScale, crop=$vScale:$vScale" "$outputPath/${inputName}-thumb.mp4"
    # convert to all formats
    # $cmdFfmpeg -y -i "$inputFile" -threads 0 -vcodec libvpx -b:v "${vBitrate}k" -maxrate "${vBitrate}k" -bufsize "${vBitrate}k" -vf "scale=-2:$vScale, crop=$vScale:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/${inputName}-thumb.webm" \
    #   -vcodec libx264 -preset slow -b:v "${vBitrate}k" -maxrate "${vBitrate}k" -bufsize "${vBitrate}k" -vf "scale=-2:$vScale, crop=$vScale:$vScale" "$outputPath/${inputName}-thumb.mp4" \
    #   -c:v libx264 -preset slow -g 30 -b:v 2800k -maxrate 3200k -bufsize 2000k -vf "scale=-2:1080" "$tempPath/$inputName-1080.mp4" \
    #   -c:v libx264 -preset slow -g 30 -b:v 2000k -maxrate 2400k -bufsize 2000k -vf "scale=-2:720" "$tempPath/$inputName-720.mp4" \
    #   -c:v libx264 -preset slow -g 30 -b:v 900k -maxrate 1200k -bufsize 900k -vf "scale=-2:540" "$tempPath/$inputName-540.mp4" \
    #   -c:v libx264 -preset slow -g 30 -b:v 300k -maxrate 400k -bufsize 300k -vf "scale=-2:320" "$tempPath/$inputName-320.mp4" \
    #   -c:v libx264 -preset slow -b:v 1500k -maxrate 2000k -bufsize 1024k -vf "scale=-2:540" "$outputPath/$inputName.mp4" \
    #   -c:v libvpx -b:v 1500k -maxrate 2000k -bufsize 1024k -vf "scale=-2:540" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/${inputName}.webm"

    echo "Creating still images.."
    # creating still images
    $cmdFfmpeg -y -ss 2 -i "$inputFile" -threads 0 -vf "select=gt(scene\,0.2)" -frames:v 1 -vsync vfr -vf "fps=fps=1/20" -vf "scale=-2:$vScale, crop=$vScale:$vScale" "$outputPath/${inputName}-thumb.jpg"
    # creating dash mpeg files
    #$cmdMp4box -dash 2000 -rap -frag-rap -profile onDemand -out "$outputPath/$inputName.mpd" "$tempPath/$inputName-320.mp4#video" "$tempPath/$inputName-540.mp4#video" "$tempPath/$inputName-720.mp4#video" "$tempPath/$inputName-1080.mp4#video"

done

# removing temporary paths
rm -R "$tempPath"
#:finish

echo "FINISHED!"
