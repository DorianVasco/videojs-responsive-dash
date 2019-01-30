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


tempPath="$inputPath/tmp-output-$(date +%s%3N)"
outputPath="$inputPath/Output"

# create output directory
mkdir "$outputPath"

#read -p "Set video height [1080]: " vScale
vScale=${vScale:-1080}
#echo "$vScale"

#read -p "Set bitrate [2000]: " vBitrate
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

# $cmdFfmpeg -y -i "$inputFile" -vcodec libx264 -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$inputName.mp4"

echo "== encoding to 1080p.. =="
vScale=1080
vBitrate=18000
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp
vName=${inputName}_1080p
$cmdFfmpeg -y -i "$inputFile"  -vcodec libvpx -preset veryslow -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$vName.webm" \
  -vcodec libvpx -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.ogv" \
  -vcodec libx264 -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.mp4"

echo "== encoding to 720p HQ.. =="
vScale=720
vBitrate=2500
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp
vName=${inputName}_720p_HQ
$cmdFfmpeg -y -i "$inputFile"  -vcodec libvpx -preset veryslow -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$vName.webm" \
-vcodec libvpx -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.ogv" \
-vcodec libx264 -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.mp4"

echo "== encoding to 720p.. =="
vScale=720
vBitrate=1400
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp
vName=${inputName}_720p
$cmdFfmpeg -y -i "$inputFile"  -vcodec libvpx -preset veryslow -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$vName.webm" \
-vcodec libvpx -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.ogv" \
-vcodec libx264 -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.mp4"

echo "== encoding to 360p HQ.. =="
vScale=360
vBitrate=1000
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp
vName=${inputName}_360p_HQ
$cmdFfmpeg -y -i "$inputFile"  -vcodec libvpx -preset veryslow -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$vName.webm" \
-vcodec libvpx -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.ogv" \
-vcodec libx264 -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.mp4"

echo "== encoding to 360p.. =="
vScale=360
vBitrate=750
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp
vName=${inputName}_360p
$cmdFfmpeg -y -i "$inputFile"  -vcodec libvpx -preset veryslow -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$vName.webm" \
-vcodec libvpx -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.ogv" \
-vcodec libx264 -preset veryslow -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$vName.mp4"






#:finish


echo "FINISHED!"
