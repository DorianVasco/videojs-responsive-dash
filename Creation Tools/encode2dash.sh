#!/bin/bash
echo "============================="
echo "== MEGA MPEG4 DASH CREATOR =="
echo "============================="

cd "${0%/*}"


# get input file per drag and drop
read -p "Drag input file here: " inputFile

#echo "Datei::$inputFile::"

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
mkdir "$tempPath"

echo "======================"
echo "== start encoding.. =="
echo "======================"

#read -p "Set video height [1080]: " vScale
#vScale=${vScale:-1080}
if [[ "$OSTYPE" == "msys" ]]; then
  cmdFfmpeg="./bin/win/ffmpeg.exe"
  cmdMp4box="./bin/win/mp4box.exe"
else
  cmdFfmpeg="./bin/mac/ffmpeg"
  cmdMp4box="./bin/mac/MP4Box"
fi

$cmdFfmpeg -y -i "$inputFile" -c:v libx264 -g 25 -b:v 2800k -maxrate 3200k -bufsize 2000k -vf "scale=-2:1080" "$tempPath/$inputName-1080.mp4" \
  -c:v libx264 -g 25 -b:v 2000k -maxrate 2400k -bufsize 2000k -vf "scale=-2:720" "$tempPath/$inputName-720.mp4" \
  -c:v libx264 -g 25 -b:v 900k -maxrate 1200k -bufsize 900k -vf "scale=-2:540" "$tempPath/$inputName-540.mp4" \
  -c:v libx264 -g 25 -b:v 300k -maxrate 400k -bufsize 300k -vf "scale=-2:320" "$tempPath/$inputName-320.mp4"


$cmdFfmpeg -ss 2 -i "$inputFile" -vf "select=gt(scene\,0.2)" -frames:v 4 -vsync vfr -vf fps=fps=1/20 -vf "scale=-2:720" "$outputPath/$inputName-%02d.jpg"


$cmdMp4box -dash 2000 -rap -frag-rap -profile onDemand -out "$outputPath/$inputName.mpd" "$tempPath/$inputName-320.mp4#audio" "$tempPath/$inputName-320.mp4#video" "$tempPath/$inputName-540.mp4#video" "$tempPath/$inputName-720.mp4#video" "$tempPath/$inputName-1080.mp4#video"


#remove temp directory with its contents
rm -R "$tempPath"

echo "FINISHED!"
