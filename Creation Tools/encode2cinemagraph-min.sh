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

#echo "stripped: $inputFile"

inputFilename="${inputFile##*/}"
inputName="${inputFilename%.*}"
inputPath="$(dirname "$inputFile")"

tempPath="$inputPath/tmp-output-$(date +%s%3N)"
outputPath="$inputPath/Output"

# create output directory
mkdir "$outputPath"
mkdir "$tempPath"

vScale=400

vBitrate=300

# set average bitrate
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp

echo "======================"
echo "== start encoding.. =="
echo "======================"

#ffmpeg -y -i "%inputFile%" -vcodec libvpx -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "%outputPath%\%inputFileName%.webm"
#ffmpeg -i movie.file -vcodec libvpx -b:v 600k -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -vf scale=480:-1 -map 0 out.webm

#echo creating MP4..
#ffmpeg -y -i "%inputFile%" -c:v libx264 -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"

#./ffmpeg.exe -y -i "$inputFile" -vcodec libvpx -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$inputFileName.webm" #-vcodec libx264 -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"

if [[ "$OSTYPE" == "msys" ]]; then
  cmdFfmpeg="./bin/win/ffmpeg.exe"
  cmdMp4box="./bin/win/mp4box.exe"
else
  cmdFfmpeg="./bin/mac/ffmpeg"
  cmdMp4box="./bin/mac/MP4Box"
fi

echo "Encoding video to large and small sizes"

$cmdFfmpeg -y -i "$inputFile" -threads 0 -c:v libx264 -preset veryslow -b:v 1500k -maxrate 2000k -bufsize 1024k -vf "scale=-2:540" "$outputPath/$inputName.mp4" \
  -c:v libvpx -b:v 1500k -maxrate 2000k -bufsize 1024k -vf "scale=-2:540" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/${inputName}.webm"

echo "Creating still images.."
$cmdFfmpeg -y -ss 2 -i "$inputFile" -threads 0 -vf "select=gt(scene\,0.1)" -frames:v 1 -vsync vfr -vf "fps=fps=1/20" -vf "scale=-2:540", "$outputPath/${inputName}.jpg"

rm -R "$tempPath"

#:finish


echo "FINISHED!"
