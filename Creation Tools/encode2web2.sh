#!/bin/bash
echo "==============================="
echo "==== MEGA MP4:WEBM CREATOR ===="
echo "==============================="

cd "$(dirname "$0")"

# get input file per drag and drop
read -r -p "Drag input file here: " inputFile
echo $inputFile
# Convert Windows path to WSL path
inputFile=$(wslpath -u "$inputFile")

# remove "" or ''
inputFile=${inputFile%\"}
inputFile=${inputFile#\"}
inputFile=${inputFile%\'}
inputFile=${inputFile#\'}
# remove leading whitespace
inputFile=${inputFile##*( )}
# remove trailing whitespace
inputFile=${inputFile%%*( )}

# Convert the Windows path to a WSL-compatible path
if [[ "$inputFile" =~ ^([a-zA-Z]): ]]; then
  driveLetter="${BASH_REMATCH[1],,}"  # Extract the drive letter and convert to lowercase
  inputFile="/mnt/$driveLetter${inputFile:2}"
fi

# Output paths
echo "Processed input file path for WSL: $inputFile"

inputFilename="${inputFile##*/}"
inputName="${inputFilename%.*}"
inputPath="$(dirname "$inputFile")"

# Print the extracted components for debugging
echo "Input file name: '$inputFilename'"
echo "Input base name: '$inputName'"
echo "Extracted directory path: '$inputPath'"


tempPath="$inputPath/tmp-output-$(date +%s%3N)"
outputPath="$inputPath/Output"

# create output directory
mkdir -p "$outputPath"

read -p "Set video height [1080]: " vScale
vScale=${vScale:-1080}

read -p "Set bitrate [2000]: " vBitrate
vBitrate=${vBitrate:-2000}

# set average bitrate
let tmp=$vBitrate/6
let vMax=$vBitrate+$tmp

echo "======================"
echo "== start encoding.. =="
echo "======================"

cmdFfmpeg="ffmpeg"

#$cmfFfmpeg -y -i "$inputFile" -c:v libvpx-vp9 -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -c:a libvorbis -b:a 96k -ar 44100 "$outputPath/$inputName.webm" \
#-c:v libtheora -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" "$outputPath/$inputName.ogv" #\
# -c:v libx264 -preset veryslow -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:$vScale" -c:a aac -b:a 128k "$outputPath/$inputName.mp4"

ffmpeg -y -i "$inputFile" -c:v libvpx-vp9 -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:1080$vScale" -c:a libvorbis -b:a 96k -ar 44100 "$outputPath/$inputName_1080p.webm" \
-c:v libtheora -b:v "${vBitrate}k" -maxrate "${vMax}k" -bufsize "${vMax}k" -vf "scale=-2:1080" "$outputPath/$inputName_1080p.ogv" #\
#-c:v libvpx-vp9 -b:v "1700k" -maxrate "2000k" -bufsize "2000k" -vf "scale=-2:720" -c:a libvorbis -b:a 96k -ar 44100 "$outputPath/$inputName_720p.webm" \
#-c:v libtheora -b:v "1700k" -maxrate "2000k" -bufsize "2000k" -vf "scale=-2:720" "$outputPath/$inputName_720p.ogv"

echo "Creating still images.."
ffmpeg -ss 6 -i "$inputFile" -vf "select=gt(scene\,0.2)" -preset veryslow -frames:v 1 -vsync vfr -vf fps=fps=1/20 -vf "scale=-2:$vScale" "$outputPath/$inputName.jpg"

echo "FINISHED!"
