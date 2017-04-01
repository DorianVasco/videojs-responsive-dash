#!/bin/bash
echo "============================================"
echo "==== MEGA CINEMAGRAPH THUMBNAIL CREATOR ===="
echo "============================================"
echo "== creates scaled and cropped videothumbs =="
echo "============================================"

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


outputPath="$inputPath/Output"

# create output directory
mkdir "$outputPath"

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
  cmd="./bin/win/ffmpeg.exe"
else
  cmd="./bin/mac/ffmpeg"
fi

$cmd -y -i "$inputFile" -vcodec libvpx -b:v "${vBitrate}k" -maxrate "${vBitrate}k" -bufsize "${vBitrate}k" -vf "scale=-2:$vScale, crop=$vScale:$vScale" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "$outputPath/$inputName.webm" \
  -vcodec libx264 -b:v ${vBitrate}k -maxrate ${vBitrate}k -bufsize ${vBitrate}k -vf "scale=-2:$vScale, crop=$vScale:$vScale" "$outputPath/$inputName.mp4"

echo "Creating still images.."
$cmd -ss 2 -i "$inputFile" -vf "select=gt(scene\,0.2)" -frames:v 1 -vsync vfr -vf fps=fps=1/20 -vf "scale=-2:$vScale, crop=$vScale:$vScale" "$outputPath/$inputName.jpg"

#$cmdFfmpeg -ss 2 -i "$inputFile" -vf "select=gt(scene\,0.2)" -frames:v 4 -vsync vfr -vf fps=fps=1/20 -vf "scale=-2:($vScale/2)" "$outputPath/$inputName-thumbnail-%02d.jpg"


#:finish


echo "FINISHED!"
