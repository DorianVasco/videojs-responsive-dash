@echo off
echo =============================
echo == MEGA MPEG4 DASH CREATOR ==
echo =============================

:: get input file per drag and drop
set /p inputFile="Drag input file here: "

set inputFile=%inputFile:"=%


:: extract path from input
FOR %%i IN ("%inputFile%") DO (
  set inputPath=%%~dpi
  set inputFileName=%%~ni
)
echo pfad = %inputPath%
echo datei = %inputFileName%

set tempPath=%inputPath%tmp-output
set outputPath=%inputPath%Output
:: create temp directory for  encoding
mkdir "%tempPath%"

:: create output directory
mkdir "%outputPath%"

:choice
set /p encChoice="Choose encoding - (1) Multiple Dash, (2) custom Preview: "

if /I "%encChoice%" EQU "1" goto :enc2dash

if /I "%encChoice%" EQU "2" goto :enc2custompreview
goto :choice

:enc2dash

:: if
ffmpeg -y -i "%inputFile%" -c:v libx264 -g 25 -b:v 2500k -maxrate 3000k -bufsize 1000k -vf "scale=-2:1080" "%tempPath%\%inputFileName%-1080.mp4" -c:v libx264 -g 25 -b:v 1800k -maxrate 2100k -bufsize 1000k -vf "scale=-2:720" "%tempPath%\%inputFileName%-720.mp4" -c:v libx264 -g 25 -b:v 700k -maxrate 900k -bufsize 500k -vf "scale=-2:540" "%tempPath%\%inputFileName%-540.mp4" -c:v libx264 -g 25 -b:v 200k -maxrate 300k -bufsize 200k -vf "scale=-2:320" "%tempPath%\%inputFileName%-320.mp4"
::@echo on
MP4Box -dash 2000 -rap -frag-rap -profile onDemand -out "%outputPath%\%inputFileName%.mpd" "%tempPath%\%inputFileName%-320.mp4#audio" "%tempPath%\%inputFileName%-320.mp4#video" "%tempPath%\%inputFileName%-540.mp4#video" "%tempPath%\%inputFileName%-720.mp4#video" "%tempPath%\%inputFileName%-1080.mp4#video"


goto :finish



:enc2custompreview

set /p vScale="Set video preview width: "

ffmpeg -y -i "%inputFile%" -c:v libx264 -g 25 -b:v 200k -maxrate 200k -bufsize 200k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%-%vScale%.mp4"



:finish

:: remove temp directory with its contents
rmdir "%tempPath%" /s /q

echo FINISHED!

pause
