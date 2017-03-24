#!/bin/bash
echo "==============================="
echo "==== MEGA MP4:WEBM CREATOR ===="
echo "==============================="

cd "${0%/*}"

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

#ffmpeg -y -i "%inputFile%" -vcodec libvpx -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "%outputPath%\%inputFileName%.webm"
#ffmpeg -i movie.file -vcodec libvpx -b:v 600k -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -vf scale=480:-1 -map 0 out.webm

#echo creating MP4..
#ffmpeg -y -i "%inputFile%" -c:v libx264 -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"

#./ffmpeg.exe -y -i "$inputFile" -vcodec libvpx -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$inputFileName.webm" #-vcodec libx264 -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"

if [[ "$OSTYPE" == "msys" ]]; then
  cmd="./bin/win/ffmpeg.exe"
else
  cmd="./bin/mac/ffmpeg"
fi

$cmd -y -i "$inputFile" -vcodec libvpx -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$inputName.webm" \
  -vcodec libx264 -b:v ${vBitrate}k -maxrate ${vMax}k -bufsize ${vMax}k -vf "scale=-2:$vScale" "$outputPath/$inputName.mp4"


#:finish


echo "FINISHED!"
