#!/bin/bash
echo "==============================="
echo "==== MEGA MP4:WEBM CREATOR ===="
echo "==============================="

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

#echo "$inputFilename"
#echo "$inputName"
#echo "$inputPath"


tempPath="$inputPath/tmp-output"
outputPath="$inputPath/Output"

# create output directory
mkdir "$outputPath"

read -p "Set video height [1080]: " vScale
vScale=${vScale:-1080}
#echo "$vScale"

read -p "Set bitrate [2000]: " vBitrate
vBitrate=${vBitrate:-2000}
#echo "$vBitrate"
#set /p vBitrate="Set bitrate (e.g. 2000): "

# set average bitrate
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp

echo "======================"
echo "== start encoding.. =="
echo "======================"

if [[ "$OSTYPE" == "msys" ]]; then
  cmdFfmpeg="./bin/win/ffmpeg.exe"
else
  cmdFfmpeg="./bin/mac/ffmpeg"
fi

$cmdFfmpeg -y -i "$inputFile" -vcodec libvpx -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$inputName.webm" \
  -vcodec libx264 -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$inputName.mp4"

echo "Creating still images.."
$cmdFfmpeg -ss 2 -i "$inputFile" -vf "select=gt(scene\,0.2)" -frames:v 1 -vsync vfr -vf fps=fps=1/20 -vf "scale=-2:$vScale" "$outputPath/$inputName.jpg"


#:finish


echo "FINISHED!"
